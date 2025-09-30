<?php
require_once 'session_handler.php';
requireLogin();

// Get user data
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - AgriPower</title>
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
                    <a href="index.php" class="hover:text-green-200 transition">Home</a>
                    <a href="services.php" class="hover:text-green-200 transition">Services</a>
                    <a href="about.php" class="hover:text-green-200 transition">About</a>
                    <a href="contact.php" class="hover:text-green-200 transition">Contact</a>
                    <a href="chatbot.php" class="hover:text-green-200 transition">AI Assistant</a>
                    <!-- <a href="logout.php" class="hover:text-green-200 transition">Logout</a> -->
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
                    <a href="index.php" class="block px-3 py-2 hover:bg-green-700 rounded">Home</a>
                    <a href="services.php" class="block px-3 py-2 hover:bg-green-700 rounded">Services</a>
                    <a href="about.php" class="block px-3 py-2 hover:bg-green-700 rounded">About</a>
                    <a href="contact.php" class="block px-3 py-2 hover:bg-green-700 rounded">Contact</a>
                    <a href="chatbot.php" class="block px-3 py-2 hover:bg-green-700 rounded">AI Assistant</a>
                    <!-- <a href="logout.php" class="block px-3 py-2 hover:bg-green-700 rounded">Logout</a> -->
                </div>
            </div>
        </div>
    </nav>

    <!-- Dashboard Content -->
    <div class="pt-24 pb-12">
        <div class="container mx-auto px-4">
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8" data-aos="fade-up">
                <h1 class="text-3xl font-bold mb-4">Welcome, <?php echo htmlspecialchars($user['first_name']); ?>!</h1>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h2 class="text-xl font-semibold mb-4">Your Profile</h2>
                        <div class="space-y-2">
                            <p><span class="font-medium">Name:</span> <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></p>
                            <p><span class="font-medium">Email:</span> <?php echo htmlspecialchars($user['email']); ?></p>
                            <p><span class="font-medium">Phone:</span> <?php echo htmlspecialchars($user['phone']); ?></p>
                            <p><span class="font-medium">Farm Location:</span> <?php echo htmlspecialchars($user['farm_location']); ?></p>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold mb-4">Quick Actions</h2>
                        <div class="space-y-4">
                            <a href="power_usage.php" class="block w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 transition duration-300 text-center">
                                View Power Usage
                            </a>
                            <a href="maintenance.php" class="block w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 transition duration-300 text-center">
                                Schedule Maintenance
                            </a>
                            <a href="billing.php" class="block w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 transition duration-300 text-center">
                                View Billing
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Power Usage Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-lg p-6" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="text-xl font-semibold mb-4">Current Usage</h3>
                    <div class="text-3xl font-bold text-green-600">2.4 kW</div>
                    <p class="text-gray-600">Active power consumption</p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-6" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="text-xl font-semibold mb-4">Monthly Average</h3>
                    <div class="text-3xl font-bold text-green-600">1.8 kW</div>
                    <p class="text-gray-600">Based on last 30 days</p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-6" data-aos="fade-up" data-aos-delay="300">
                    <h3 class="text-xl font-semibold mb-4">Cost Savings</h3>
                    <div class="text-3xl font-bold text-green-600">15%</div>
                    <p class="text-gray-600">Compared to last month</p>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-lg shadow-lg p-6" data-aos="fade-up">
                <h2 class="text-2xl font-bold mb-4">Recent Activity</h2>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <h4 class="font-semibold">System Maintenance</h4>
                            <p class="text-gray-600">Regular checkup completed</p>
                        </div>
                        <span class="text-sm text-gray-500">2 days ago</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <h4 class="font-semibold">Power Usage Alert</h4>
                            <p class="text-gray-600">Unusual spike detected</p>
                        </div>
                        <span class="text-sm text-gray-500">5 days ago</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <h4 class="font-semibold">Bill Payment</h4>
                            <p class="text-gray-600">Monthly payment received</p>
                        </div>
                        <span class="text-sm text-gray-500">1 week ago</span>
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
                        <li><a href="index.php" class="text-gray-400 hover:text-white">Home</a></li>
                        <li><a href="services.php" class="text-gray-400 hover:text-white">Services</a></li>
                        <li><a href="about.php" class="text-gray-400 hover:text-white">About</a></li>
                        <li><a href="contact.php" class="text-gray-400 hover:text-white">Contact</a></li>
                        <li><a href="government_policies.php" class="text-gray-400 hover:text-white">Government Policies</a></li>
                        <li><a href="chatbot.php" class="text-gray-400 hover:text-white">AI Assistant</a></li>
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
    </script>
</body>
</html> 