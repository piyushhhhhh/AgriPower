<?php
require_once 'session_handler.php';
requireLogin();

// Get user data
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Simulated power usage data (in a real application, this would come from a database or API)
$powerData = [
    'daily' => [
        'labels' => ['00:00', '03:00', '06:00', '09:00', '12:00', '15:00', '18:00', '21:00'],
        'data' => [1.2, 0.8, 1.5, 2.1, 2.4, 2.2, 1.9, 1.6]
    ],
    'weekly' => [
        'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        'data' => [42, 38, 45, 40, 43, 35, 37]
    ],
    'monthly' => [
        'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        'data' => [1200, 1150, 1300, 1250, 1400, 1350, 1450, 1400, 1350, 1300, 1250, 1200]
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Power Usage - AgriPower</title>
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

    <!-- Power Usage Content -->
    <div class="pt-24 pb-12">
        <div class="container mx-auto px-4">
            <!-- Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-lg p-6" data-aos="fade-up">
                    <h3 class="text-xl font-semibold mb-4">Current Usage</h3>
                    <div class="text-3xl font-bold text-green-600">2.4 kW</div>
                    <p class="text-gray-600">Active power consumption</p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-6" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="text-xl font-semibold mb-4">Daily Average</h3>
                    <div class="text-3xl font-bold text-green-600">1.8 kW</div>
                    <p class="text-gray-600">Last 24 hours</p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-6" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="text-xl font-semibold mb-4">Monthly Usage</h3>
                    <div class="text-3xl font-bold text-green-600">1,350 kWh</div>
                    <p class="text-gray-600">This month</p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-6" data-aos="fade-up" data-aos-delay="300">
                    <h3 class="text-xl font-semibold mb-4">Cost Estimate</h3>
                    <div class="text-3xl font-bold text-green-600">$245</div>
                    <p class="text-gray-600">Current month</p>
                </div>
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Daily Usage Chart -->
                <div class="bg-white rounded-lg shadow-lg p-6" data-aos="fade-up">
                    <h2 class="text-2xl font-bold mb-4">Daily Power Usage</h2>
                    <canvas id="dailyChart"></canvas>
                </div>

                <!-- Weekly Usage Chart -->
                <div class="bg-white rounded-lg shadow-lg p-6" data-aos="fade-up">
                    <h2 class="text-2xl font-bold mb-4">Weekly Power Usage</h2>
                    <canvas id="weeklyChart"></canvas>
                </div>

                <!-- Monthly Usage Chart -->
                <div class="bg-white rounded-lg shadow-lg p-6" data-aos="fade-up">
                    <h2 class="text-2xl font-bold mb-4">Monthly Power Usage</h2>
                    <canvas id="monthlyChart"></canvas>
                </div>

                <!-- Usage Breakdown -->
                <div class="bg-white rounded-lg shadow-lg p-6" data-aos="fade-up">
                    <h2 class="text-2xl font-bold mb-4">Usage Breakdown</h2>
                    <canvas id="breakdownChart"></canvas>
                </div>
            </div>

            <!-- Tips and Recommendations -->
            <div class="mt-8 bg-white rounded-lg shadow-lg p-6" data-aos="fade-up">
                <h2 class="text-2xl font-bold mb-4">Power Saving Tips</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold">Optimize Irrigation Schedule</h4>
                                <p class="text-gray-600">Water during off-peak hours to reduce power costs.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold">Regular Maintenance</h4>
                                <p class="text-gray-600">Keep equipment well-maintained for optimal efficiency.</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold">Use Smart Controls</h4>
                                <p class="text-gray-600">Implement automated systems for better power management.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold">Monitor Weather Patterns</h4>
                                <p class="text-gray-600">Adjust power usage based on weather forecasts.</p>
                            </div>
                        </div>
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

        // Chart configuration
        const chartConfig = {
            type: 'line',
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // Daily usage chart
        const dailyChart = new Chart(
            document.getElementById('dailyChart'),
            {
                ...chartConfig,
                data: {
                    labels: <?php echo json_encode($powerData['daily']['labels']); ?>,
                    datasets: [{
                        label: 'Power Usage (kW)',
                        data: <?php echo json_encode($powerData['daily']['data']); ?>,
                        borderColor: 'rgb(22, 163, 74)',
                        tension: 0.1
                    }]
                }
            }
        );

        // Weekly usage chart
        const weeklyChart = new Chart(
            document.getElementById('weeklyChart'),
            {
                ...chartConfig,
                data: {
                    labels: <?php echo json_encode($powerData['weekly']['labels']); ?>,
                    datasets: [{
                        label: 'Power Usage (kWh)',
                        data: <?php echo json_encode($powerData['weekly']['data']); ?>,
                        borderColor: 'rgb(22, 163, 74)',
                        tension: 0.1
                    }]
                }
            }
        );

        // Monthly usage chart
        const monthlyChart = new Chart(
            document.getElementById('monthlyChart'),
            {
                ...chartConfig,
                data: {
                    labels: <?php echo json_encode($powerData['monthly']['labels']); ?>,
                    datasets: [{
                        label: 'Power Usage (kWh)',
                        data: <?php echo json_encode($powerData['monthly']['data']); ?>,
                        borderColor: 'rgb(22, 163, 74)',
                        tension: 0.1
                    }]
                }
            }
        );

        // Usage breakdown chart
        const breakdownChart = new Chart(
            document.getElementById('breakdownChart'),
            {
                type: 'pie',
                data: {
                    labels: ['Irrigation', 'Processing', 'Storage', 'Lighting', 'Other'],
                    datasets: [{
                        data: [40, 25, 15, 12, 8],
                        backgroundColor: [
                            'rgb(22, 163, 74)',
                            'rgb(16, 185, 129)',
                            'rgb(6, 182, 212)',
                            'rgb(59, 130, 246)',
                            'rgb(99, 102, 241)'
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