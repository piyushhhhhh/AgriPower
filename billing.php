<?php
require_once 'session_handler.php';
requireLogin();

// Get user data
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Create billing_records table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS billing_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    billing_period VARCHAR(7) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    usage_kwh DECIMAL(10,2) NOT NULL,
    due_date DATE NOT NULL,
    status VARCHAR(20) DEFAULT 'unpaid',
    payment_date DATE NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";

if (!$conn->query($sql)) {
    die("Error creating billing_records table: " . $conn->error);
}

// Get user's billing records
$stmt = $conn->prepare("SELECT * FROM billing_records WHERE user_id = ? ORDER BY billing_period DESC LIMIT 12");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$billing_records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Calculate total amount due
$total_due = 0;
foreach ($billing_records as $record) {
    if ($record['status'] === 'unpaid') {
        $total_due += $record['amount'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing - AgriPower</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    <!-- Billing Content -->
    <div class="pt-24 pb-12">
        <div class="container mx-auto px-4">
            <!-- Billing Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-lg p-6" data-aos="fade-up">
                    <h3 class="text-xl font-semibold mb-4">Total Amount Due</h3>
                    <div class="text-3xl font-bold text-green-600">$<?php echo number_format($total_due, 2); ?></div>
                    <p class="text-gray-600">Current balance</p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-6" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="text-xl font-semibold mb-4">Last Bill Amount</h3>
                    <div class="text-3xl font-bold text-green-600">
                        $<?php echo !empty($billing_records) ? number_format($billing_records[0]['amount'], 2) : '0.00'; ?>
                    </div>
                    <p class="text-gray-600">For <?php echo !empty($billing_records) ? date('F Y', strtotime($billing_records[0]['billing_period'] . '-01')) : 'N/A'; ?></p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-6" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="text-xl font-semibold mb-4">Last Payment</h3>
                    <div class="text-3xl font-bold text-green-600">
                        <?php
                        $last_payment = null;
                        foreach ($billing_records as $record) {
                            if ($record['status'] === 'paid') {
                                $last_payment = $record;
                                break;
                            }
                        }
                        echo $last_payment ? '$' . number_format($last_payment['amount'], 2) : 'No payments';
                        ?>
                    </div>
                    <p class="text-gray-600">
                        <?php echo $last_payment ? 'Paid on ' . date('M j, Y', strtotime($last_payment['payment_date'])) : 'No payment history'; ?>
                    </p>
                </div>
            </div>

            <!-- Billing History -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8" data-aos="fade-up">
                <h2 class="text-2xl font-bold mb-6">Billing History</h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Billing Period</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usage (kWh)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (empty($billing_records)): ?>
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No billing records found.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($billing_records as $record): ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?php echo date('F Y', strtotime($record['billing_period'] . '-01')); ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?php echo number_format($record['usage_kwh'], 2); ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            $<?php echo number_format($record['amount'], 2); ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?php echo date('M j, Y', strtotime($record['due_date'])); ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php
                                                echo match($record['status']) {
                                                    'paid' => 'bg-green-100 text-green-800',
                                                    'unpaid' => 'bg-red-100 text-red-800',
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    default => 'bg-gray-100 text-gray-800'
                                                };
                                            ?>">
                                                <?php echo ucfirst($record['status']); ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?php if ($record['status'] === 'unpaid'): ?>
                                                <a href="process_payment.php?bill_id=<?php echo $record['id']; ?>"
                                                    class="text-green-600 hover:text-green-900">Pay Now</a>
                                            <?php else: ?>
                                                <a href="download_invoice.php?bill_id=<?php echo $record['id']; ?>"
                                                    class="text-blue-600 hover:text-blue-900">Download Invoice</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Usage Trends -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Monthly Usage Chart -->
                <div class="bg-white rounded-lg shadow-lg p-6" data-aos="fade-up">
                    <h2 class="text-2xl font-bold mb-4">Monthly Usage Trends</h2>
                    <canvas id="usageChart"></canvas>
                </div>

                <!-- Cost Breakdown -->
                <div class="bg-white rounded-lg shadow-lg p-6" data-aos="fade-up">
                    <h2 class="text-2xl font-bold mb-4">Cost Breakdown</h2>
                    <canvas id="costChart"></canvas>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="mt-8 bg-white rounded-lg shadow-lg p-6" data-aos="fade-up">
                <h2 class="text-2xl font-bold mb-6">Payment Methods</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="border rounded-lg p-4">
                        <div class="flex items-center mb-4">
                            <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold">Credit Card</h3>
                        </div>
                        <p class="text-gray-600">Pay securely using your credit card.</p>
                    </div>
                    <div class="border rounded-lg p-4">
                        <div class="flex items-center mb-4">
                            <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                            </svg>
                            <h3 class="text-lg font-semibold">Bank Transfer</h3>
                        </div>
                        <p class="text-gray-600">Direct transfer from your bank account.</p>
                    </div>
                    <div class="border rounded-lg p-4">
                        <div class="flex items-center mb-4">
                            <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold">Auto-Pay</h3>
                        </div>
                        <p class="text-gray-600">Set up automatic monthly payments.</p>
                    </div>
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

        // Prepare chart data
        const usageData = {
            labels: <?php
                echo json_encode(array_map(function($record) {
                    return date('M Y', strtotime($record['billing_period'] . '-01'));
                }, array_reverse($billing_records)));
            ?>,
            datasets: [{
                label: 'Power Usage (kWh)',
                data: <?php
                    echo json_encode(array_map(function($record) {
                        return $record['usage_kwh'];
                    }, array_reverse($billing_records)));
                ?>,
                borderColor: 'rgb(22, 163, 74)',
                tension: 0.1
            }]
        };

        // Usage chart
        new Chart(
            document.getElementById('usageChart'),
            {
                type: 'line',
                data: usageData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            }
        );

        // Cost breakdown chart
        new Chart(
            document.getElementById('costChart'),
            {
                type: 'pie',
                data: {
                    labels: ['Base Rate', 'Peak Usage', 'Taxes', 'Service Charges'],
                    datasets: [{
                        data: [60, 25, 10, 5],
                        backgroundColor: [
                            'rgb(22, 163, 74)',
                            'rgb(16, 185, 129)',
                            'rgb(6, 182, 212)',
                            'rgb(59, 130, 246)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            }
        );
    </script>
</body>
</html> 