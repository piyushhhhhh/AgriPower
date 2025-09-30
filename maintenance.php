<?php
require_once 'session_handler.php';
requireLogin();

// Get user data
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Create maintenance_requests table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS maintenance_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    service_type VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    preferred_date DATE NOT NULL,
    preferred_time VARCHAR(20) NOT NULL,
    status VARCHAR(20) DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";

if (!$conn->query($sql)) {
    die("Error creating maintenance_requests table: " . $conn->error);
}

// Get user's maintenance requests
$stmt = $conn->prepare("SELECT * FROM maintenance_requests WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$maintenance_requests = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Maintenance - AgriPower</title>
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

    <!-- Maintenance Content -->
    <div class="pt-24 pb-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Schedule Maintenance Form -->
                <div class="bg-white rounded-lg shadow-lg p-6" data-aos="fade-up">
                    <h2 class="text-2xl font-bold mb-6">Schedule Maintenance</h2>
                    <form action="process_maintenance.php" method="POST" class="space-y-6">
                        <div>
                            <label for="service_type" class="block text-gray-700 mb-2">Service Type</label>
                            <select id="service_type" name="service_type" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
                                <option value="">Select a service type</option>
                                <option value="routine_inspection">Routine Inspection</option>
                                <option value="equipment_repair">Equipment Repair</option>
                                <option value="system_upgrade">System Upgrade</option>
                                <option value="emergency_service">Emergency Service</option>
                                <option value="preventive_maintenance">Preventive Maintenance</option>
                            </select>
                        </div>
                        <div>
                            <label for="description" class="block text-gray-700 mb-2">Description</label>
                            <textarea id="description" name="description" rows="4" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500"
                                placeholder="Please describe the maintenance needed..."></textarea>
                        </div>
                        <div>
                            <label for="preferred_date" class="block text-gray-700 mb-2">Preferred Date</label>
                            <input type="date" id="preferred_date" name="preferred_date" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500"
                                min="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div>
                            <label for="preferred_time" class="block text-gray-700 mb-2">Preferred Time</label>
                            <select id="preferred_time" name="preferred_time" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
                                <option value="">Select a time slot</option>
                                <option value="morning">Morning (8:00 AM - 12:00 PM)</option>
                                <option value="afternoon">Afternoon (1:00 PM - 5:00 PM)</option>
                                <option value="evening">Evening (6:00 PM - 8:00 PM)</option>
                            </select>
                        </div>
                        <button type="submit"
                            class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition duration-300">
                            Schedule Maintenance
                        </button>
                    </form>
                </div>

                <!-- Maintenance History -->
                <div class="bg-white rounded-lg shadow-lg p-6" data-aos="fade-up">
                    <h2 class="text-2xl font-bold mb-6">Maintenance History</h2>
                    <div class="space-y-4">
                        <?php if (empty($maintenance_requests)): ?>
                            <p class="text-gray-600">No maintenance requests found.</p>
                        <?php else: ?>
                            <?php foreach ($maintenance_requests as $request): ?>
                                <div class="border rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-semibold"><?php echo ucwords(str_replace('_', ' ', $request['service_type'])); ?></h4>
                                            <p class="text-gray-600"><?php echo htmlspecialchars($request['description']); ?></p>
                                            <p class="text-sm text-gray-500 mt-2">
                                                Scheduled for: <?php echo date('M j, Y', strtotime($request['preferred_date'])); ?> 
                                                (<?php echo ucfirst($request['preferred_time']); ?>)
                                            </p>
                                        </div>
                                        <span class="px-3 py-1 rounded-full text-sm <?php
                                            echo match($request['status']) {
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'approved' => 'bg-green-100 text-green-800',
                                                'completed' => 'bg-blue-100 text-blue-800',
                                                'cancelled' => 'bg-red-100 text-red-800',
                                                default => 'bg-gray-100 text-gray-800'
                                            };
                                        ?>">
                                            <?php echo ucfirst($request['status']); ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Maintenance Tips -->
            <div class="mt-8 bg-white rounded-lg shadow-lg p-6" data-aos="fade-up">
                <h2 class="text-2xl font-bold mb-6">Maintenance Tips</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <div class="flex items-center text-green-600">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <h4 class="font-semibold">Regular Inspections</h4>
                        </div>
                        <p class="text-gray-600">Schedule routine inspections every 3 months to ensure optimal system performance.</p>
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center text-green-600">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <h4 class="font-semibold">Clean Equipment</h4>
                        </div>
                        <p class="text-gray-600">Keep equipment clean and free from debris to prevent performance issues.</p>
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center text-green-600">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <h4 class="font-semibold">Monitor Performance</h4>
                        </div>
                        <p class="text-gray-600">Regularly check system performance metrics and report any unusual changes.</p>
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
    </script>
</body>
</html> 