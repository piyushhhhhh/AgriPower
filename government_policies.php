<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Government Policies - AgriPower</title>
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
                    <!-- <a href="login.php" class="hover:text-green-200 transition">Login</a> -->
                </div>
                <button class="md:hidden" id="mobile-menu-button">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
            <!-- Mobile Menu -->
            <div class="md:hidden hidden" id="mobile-menu">
                <a href="index.php" class="block py-2 px-4 hover:bg-green-700">Home</a>
                <a href="services.php" class="block py-2 px-4 hover:bg-green-700">Services</a>
                <a href="about.php" class="block py-2 px-4 hover:bg-green-700">About</a>
                <a href="contact.php" class="block py-2 px-4 hover:bg-green-700">Contact</a>
                <a href="chatbot.php" class="block py-2 px-4 hover:bg-green-700">AI Assistant</a>
                <!-- <a href="login.php" class="block py-2 px-4 hover:bg-green-700">Login</a> -->
            </div>
        </div>
    </nav>

    <!-- Government Policies Header -->
    <section class="pt-24 pb-12 bg-green-600 text-white">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl md:text-5xl font-bold text-center mb-4" data-aos="fade-up">Government Policies</h1>
            <p class="text-xl text-center max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                Information about Government Policies/Subsidies/Schemes
            </p>
        </div>
    </section>

    <!-- Government Policies Grid -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden" data-aos="fade-up">
                    <div class="p-6">
                        <div class="text-green-600 text-4xl mb-4">⚡</div>
                        <h3 class="text-2xl font-semibold mb-4">PM-KUSUM</h3>
                        <p class="text-gray-600 mb-4">Launched in March 2019, PM-KUSUM aims to increase farmers' income and provide reliable irrigation sources by promoting the use of solar energy in agriculture.</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                    <div class="p-6">
                        <div class="text-green-600 text-4xl mb-4">🌿</div>
                        <h3 class="text-2xl font-semibold mb-4">Jyotigram Yojana</h3>
                        <p class="text-gray-600 mb-4">The scheme involves separating feeder lines to ensure uninterrupted power for both agricultural and household use.</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                    <div class="p-6">
                        <div class="text-green-600 text-4xl mb-4">🌳</div>
                        <h3 class="text-2xl font-semibold mb-4">Transmission and Distribution Subsidies</h3>
                        <p class="text-gray-600 mb-4">The Indian government allocates substantial funds to subsidize electricity transmission and distribution, benefiting the agricultural sector.</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="300">
                    <div class="p-6">
                        <div class="text-green-600 text-4xl mb-4">🌱</div>
                        <h3 class="text-2xl font-semibold mb-4">Maharashtra Mukhyamantri Baliraja Free Electricity Scheme</h3>
                        <p class="text-gray-600 mb-4">Under this scheme, farmers in Maharashtra using agricultural water pumps up to a capacity of 7.5 HP receive free electricity for agricultural use.</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="400">
                    <div class="p-6">
                        <div class="text-green-600 text-4xl mb-4">💧</div>
                        <h3 class="text-2xl font-semibold mb-4">Direct Benefit Transfer for Electricity (DBTE)</h3>
                        <p class="text-gray-600 mb-4">This initiative aims to create a monetary incentive for farmers who reduce electricity consumption below a specified allocation, encouraging water conservation and reducing groundwater depletion.</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="500">
                    <div class="p-6">
                        <div class="text-green-600 text-4xl mb-4">🌿</div>
                        <h3 class="text-2xl font-semibold mb-4">Maharashtra's Agricultural Policy 2020</h3>
                        <p class="text-gray-600 mb-4">The Maharashtra State Electricity Distribution Company Limited (MSEDCL) introduced measures to incentivize regular payment of electricity bills by farmers. Farmers who pay their bills on time and have no arrears receive an additional 5% discount on their current electricity bill.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
