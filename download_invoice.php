<?php
require_once 'session_handler.php';
requireLogin();

// Check if bill_id is provided
if (!isset($_GET['bill_id'])) {
    $_SESSION['error'] = "Invalid bill ID.";
    header("Location: billing.php");
    exit();
}

$bill_id = intval($_GET['bill_id']);

// Get the bill details
$stmt = $conn->prepare("SELECT br.*, u.name, u.email, u.address FROM billing_records br 
                       JOIN users u ON br.user_id = u.id 
                       WHERE br.id = ? AND br.user_id = ?");
$stmt->bind_param("ii", $bill_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$bill = $result->fetch_assoc();

if (!$bill) {
    $_SESSION['error'] = "Bill not found or unauthorized access.";
    header("Location: billing.php");
    exit();
}

if ($bill['status'] !== 'paid') {
    $_SESSION['error'] = "Invoice is only available for paid bills.";
    header("Location: billing.php");
    exit();
}

// Set headers for HTML display
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #<?php echo $bill_id; ?> - AgriPower</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body class="bg-gray-50 p-8">
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-8">
            <!-- Invoice Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-green-600">AgriPower</h1>
                <h2 class="text-xl text-gray-600">Invoice #<?php echo $bill_id; ?></h2>
            </div>

            <!-- Invoice Details -->
            <div class="grid grid-cols-2 gap-8 mb-8">
                <div>
                    <h3 class="font-semibold mb-2">Billed To:</h3>
                    <p class="text-gray-600">
                        <?php echo htmlspecialchars($bill['name']); ?><br>
                        <?php echo htmlspecialchars($bill['address']); ?><br>
                        <?php echo htmlspecialchars($bill['email']); ?>
                    </p>
                </div>
                <div class="text-right">
                    <p class="mb-1"><strong>Invoice Date:</strong> <?php echo date('F j, Y', strtotime($bill['payment_date'])); ?></p>
                    <p class="mb-1"><strong>Billing Period:</strong> <?php echo date('F Y', strtotime($bill['billing_period'] . '-01')); ?></p>
                    <p class="mb-1"><strong>Due Date:</strong> <?php echo date('F j, Y', strtotime($bill['due_date'])); ?></p>
                    <p><strong>Status:</strong> <span class="text-green-600">Paid</span></p>
                </div>
            </div>

            <!-- Invoice Items -->
            <div class="mb-8">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="py-2 px-4 text-left border">Description</th>
                            <th class="py-2 px-4 text-left border">Usage (kWh)</th>
                            <th class="py-2 px-4 text-left border">Rate</th>
                            <th class="py-2 px-4 text-left border">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-2 px-4 border">Base Power Consumption</td>
                            <td class="py-2 px-4 border"><?php echo number_format($bill['usage_kwh'] * 0.6, 2); ?></td>
                            <td class="py-2 px-4 border">$0.12/kWh</td>
                            <td class="py-2 px-4 border">$<?php echo number_format($bill['amount'] * 0.6, 2); ?></td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border">Peak Usage Charges</td>
                            <td class="py-2 px-4 border"><?php echo number_format($bill['usage_kwh'] * 0.25, 2); ?></td>
                            <td class="py-2 px-4 border">$0.15/kWh</td>
                            <td class="py-2 px-4 border">$<?php echo number_format($bill['amount'] * 0.25, 2); ?></td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border">Service Charges</td>
                            <td class="py-2 px-4 border">-</td>
                            <td class="py-2 px-4 border">-</td>
                            <td class="py-2 px-4 border">$<?php echo number_format($bill['amount'] * 0.05, 2); ?></td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border">Taxes</td>
                            <td class="py-2 px-4 border">-</td>
                            <td class="py-2 px-4 border">10%</td>
                            <td class="py-2 px-4 border">$<?php echo number_format($bill['amount'] * 0.1, 2); ?></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="font-bold">
                            <td colspan="3" class="py-2 px-4 text-right border">Total Amount:</td>
                            <td class="py-2 px-4 border">$<?php echo number_format($bill['amount'], 2); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Footer -->
            <div class="text-center text-gray-600 text-sm">
                <p class="mb-2">Thank you for choosing AgriPower for your agricultural power needs.</p>
                <p class="mb-2">For any questions about this invoice, please contact our support team at support@agripower.com</p>
                <p>AgriPower Inc. | 123 Farm Road, Rural City | (555) 123-4567</p>
            </div>

            <!-- Print Button -->
            <div class="mt-8 text-center no-print">
                <button onclick="window.print()" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                    Print Invoice
                </button>
                <a href="billing.php" class="ml-4 text-gray-600 hover:text-gray-800">
                    Back to Billing
                </a>
            </div>
        </div>
    </div>
</body>
</html> 