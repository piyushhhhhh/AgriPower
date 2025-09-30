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
$stmt = $conn->prepare("SELECT * FROM billing_records WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $bill_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$bill = $result->fetch_assoc();

if (!$bill) {
    $_SESSION['error'] = "Bill not found or unauthorized access.";
    header("Location: billing.php");
    exit();
}

if ($bill['status'] !== 'unpaid') {
    $_SESSION['error'] = "This bill has already been paid.";
    header("Location: billing.php");
    exit();
}

// Process the payment (this is a placeholder - in a real application, you would integrate with a payment gateway)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment_method = $_POST['payment_method'] ?? '';
    $card_number = $_POST['card_number'] ?? '';
    $expiry_date = $_POST['expiry_date'] ?? '';
    $cvv = $_POST['cvv'] ?? '';

    // Validate payment details
    $errors = [];
    if (empty($payment_method)) {
        $errors[] = "Payment method is required.";
    }
    if ($payment_method === 'credit_card') {
        if (empty($card_number) || !preg_match('/^\d{16}$/', $card_number)) {
            $errors[] = "Invalid card number.";
        }
        if (empty($expiry_date) || !preg_match('/^\d{2}\/\d{2}$/', $expiry_date)) {
            $errors[] = "Invalid expiry date.";
        }
        if (empty($cvv) || !preg_match('/^\d{3}$/', $cvv)) {
            $errors[] = "Invalid CVV.";
        }
    }

    if (empty($errors)) {
        // In a real application, you would process the payment through a payment gateway here
        // For this demo, we'll just mark the bill as paid
        $stmt = $conn->prepare("UPDATE billing_records SET status = 'paid', payment_date = CURRENT_DATE WHERE id = ?");
        $stmt->bind_param("i", $bill_id);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Payment processed successfully.";
            
            // Send payment confirmation email (placeholder)
            // mail($user['email'], "Payment Confirmation", "Your payment of $" . $bill['amount'] . " has been processed successfully.");
            
            header("Location: billing.php");
            exit();
        } else {
            $_SESSION['error'] = "Error processing payment. Please try again.";
        }
    } else {
        $_SESSION['error'] = implode("<br>", $errors);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Payment - AgriPower</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-green-600 text-white shadow-lg fixed w-full z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="index.php" class="text-2xl font-bold">AgriPower</a>
                <div class="hidden md:flex space-x-6">
                    <a href="dashboard.php" class="hover:text-green-200 transition">Dashboard</a>
                    <a href="services.php" class="hover:text-green-200 transition">Services</a>
                    <a href="about.php" class="hover:text-green-200 transition">About</a>
                    <a href="contact.php" class="hover:text-green-200 transition">Contact</a>
                    <a href="logout.php" class="hover:text-green-200 transition">Logout</a>
                </div>
                <button class="md:hidden" id="mobile-menu-button">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
            <!-- Mobile Menu -->
            <div class="md:hidden hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="dashboard.php" class="block px-3 py-2 hover:bg-green-700 rounded">Dashboard</a>
                    <a href="services.php" class="block px-3 py-2 hover:bg-green-700 rounded">Services</a>
                    <a href="about.php" class="block px-3 py-2 hover:bg-green-700 rounded">About</a>
                    <a href="contact.php" class="block px-3 py-2 hover:bg-green-700 rounded">Contact</a>
                    <a href="logout.php" class="block px-3 py-2 hover:bg-green-700 rounded">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Payment Form -->
    <div class="pt-24 pb-12">
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mx-auto">
                <div class="bg-white rounded-lg shadow-lg p-6" data-aos="fade-up">
                    <h2 class="text-2xl font-bold mb-6">Process Payment</h2>
                    
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <?php 
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Bill Details</h3>
                        <div class="bg-gray-50 p-4 rounded">
                            <p class="mb-2"><span class="font-medium">Billing Period:</span> <?php echo date('F Y', strtotime($bill['billing_period'] . '-01')); ?></p>
                            <p class="mb-2"><span class="font-medium">Amount:</span> $<?php echo number_format($bill['amount'], 2); ?></p>
                            <p class="mb-2"><span class="font-medium">Due Date:</span> <?php echo date('M j, Y', strtotime($bill['due_date'])); ?></p>
                            <p><span class="font-medium">Usage:</span> <?php echo number_format($bill['usage_kwh'], 2); ?> kWh</p>
                        </div>
                    </div>

                    <form method="POST" class="space-y-6">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Payment Method
                            </label>
                            <select name="payment_method" class="w-full border rounded px-3 py-2" required>
                                <option value="">Select payment method</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="auto_pay">Auto-Pay</option>
                            </select>
                        </div>

                        <div id="credit-card-fields" class="space-y-4 hidden">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">
                                    Card Number
                                </label>
                                <input type="text" name="card_number" 
                                    class="w-full border rounded px-3 py-2"
                                    placeholder="1234 5678 9012 3456"
                                    pattern="\d{16}"
                                    maxlength="16">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                        Expiry Date
                                    </label>
                                    <input type="text" name="expiry_date" 
                                        class="w-full border rounded px-3 py-2"
                                        placeholder="MM/YY"
                                        pattern="\d{2}/\d{2}"
                                        maxlength="5">
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                        CVV
                                    </label>
                                    <input type="text" name="cvv" 
                                        class="w-full border rounded px-3 py-2"
                                        placeholder="123"
                                        pattern="\d{3}"
                                        maxlength="3">
                                </div>
                            </div>
                        </div>

                        <div id="bank-transfer-fields" class="space-y-4 hidden">
                            <div class="bg-blue-50 p-4 rounded">
                                <h4 class="font-semibold mb-2">Bank Transfer Instructions</h4>
                                <p class="text-sm text-gray-600">
                                    Please transfer the amount to:<br>
                                    Bank: AgriPower Financial<br>
                                    Account: 1234567890<br>
                                    Routing: 987654321<br>
                                    Reference: BILL-<?php echo $bill_id; ?>
                                </p>
                            </div>
                        </div>

                        <div id="auto-pay-fields" class="space-y-4 hidden">
                            <div class="bg-green-50 p-4 rounded">
                                <h4 class="font-semibold mb-2">Auto-Pay Setup</h4>
                                <p class="text-sm text-gray-600">
                                    By selecting Auto-Pay, you agree to have your bills automatically paid on the due date using your preferred payment method.
                                </p>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <a href="billing.php" class="text-gray-600 hover:text-gray-800">
                                Cancel
                            </a>
                            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                                Process Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">AgriPower</h3>
                    <p class="text-gray-400">Empowering agriculture with sustainable energy solutions.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="dashboard.php" class="text-gray-400 hover:text-white">Dashboard</a></li>
                        <li><a href="services.php" class="text-gray-400 hover:text-white">Services</a></li>
                        <li><a href="about.php" class="text-gray-400 hover:text-white">About</a></li>
                        <li><a href="contact.php" class="text-gray-400 hover:text-white">Contact</a></li>
                        <li><a href="government_policies.php" class="text-gray-400 hover:text-white">Government Policies</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>Email: itsayush0212@gmail.com</li>
                        <li>Phone: +91 70602 49340</li>
                        <li>Address: LPU University, Jalandhar, Punjab</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 AgriPower. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true
        });

        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Payment method fields toggle
        const paymentMethodSelect = document.querySelector('select[name="payment_method"]');
        const creditCardFields = document.getElementById('credit-card-fields');
        const bankTransferFields = document.getElementById('bank-transfer-fields');
        const autoPayFields = document.getElementById('auto-pay-fields');

        paymentMethodSelect.addEventListener('change', (e) => {
            creditCardFields.classList.add('hidden');
            bankTransferFields.classList.add('hidden');
            autoPayFields.classList.add('hidden');

            switch (e.target.value) {
                case 'credit_card':
                    creditCardFields.classList.remove('hidden');
                    break;
                case 'bank_transfer':
                    bankTransferFields.classList.remove('hidden');
                    break;
                case 'auto_pay':
                    autoPayFields.classList.remove('hidden');
                    break;
            }
        });

        // Format expiry date input
        const expiryInput = document.querySelector('input[name="expiry_date"]');
        expiryInput?.addEventListener('input', (e) => {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.slice(0, 2) + '/' + value.slice(2);
            }
            e.target.value = value;
        });
    </script>
</body>
</html> 