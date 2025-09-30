<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgriPower - Electric Power Distribution for Agriculture</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-green-600 text-white shadow-lg fixed w-full z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="index.php" class="text-2xl font-bold">AgriPower</a>
                <div class="hidden md:flex space-x-6">
                    <a href="index.php" class="hover:text-green-200 transition underline">Home</a>
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
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="index.php" class="block px-3 py-2 hover:bg-green-700 rounded">Home</a>
                    <a href="services.php" class="block px-3 py-2 hover:bg-green-700 rounded">Services</a>
                    <a href="about.php" class="block px-3 py-2 hover:bg-green-700 rounded">About</a>
                    <a href="contact.php" class="block px-3 py-2 hover:bg-green-700 rounded">Contact</a>
                    <a href="chatbot.php" class="block px-3 py-2 hover:bg-green-700 rounded">AI Assistant</a>
                    <!-- <a href="login.php" class="block px-3 py-2 hover:bg-green-700 rounded">Login</a> -->
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-24 pb-12 px-4">
        <div class="container mx-auto">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2" data-aos="fade-right">
                    <h1 class="text-4xl md:text-6xl font-bold text-gray-800 mb-6">
                        Powering Agriculture with Sustainable Energy
                    </h1>
                    <p class="text-xl text-gray-600 mb-8">
                        Efficient electric power distribution solutions for modern farming needs. Empowering farmers with reliable and sustainable energy.
                    </p>
                    <a href="services.php" class="bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 transition duration-300">
                        Explore Services
                    </a>
                </div>
                <div class="md:w-1/2 mt-8 md:mt-0" data-aos="fade-left">
                    <img src="assets/images/Power-Grid.jpg" alt="Agricultural Power Distribution" class="rounded-lg shadow-xl float-animation">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12" data-aos="fade-up">Our Key Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-6 bg-gray-50 rounded-lg shadow-md" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-green-600 text-4xl mb-4">🌊</div>
                    <h3 class="text-xl font-semibold mb-2">Smart Irrigation</h3>
                    <p class="text-gray-600">Leverage AI and IoT to optimize water usage for efficient irrigation.</p>
                </div>
                <div class="p-6 bg-gray-50 rounded-lg shadow-md" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-green-600 text-4xl mb-4">💰</div>
                    <h3 class="text-xl font-semibold mb-2">Cost-Effective</h3>
                    <p class="text-gray-600">Optimized power distribution to reduce energy costs and improve efficiency.</p>
                </div>
                <div class="p-6 bg-gray-50 rounded-lg shadow-md" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-green-600 text-4xl mb-4">🌱</div>
                    <h3 class="text-xl font-semibold mb-2">Sustainable Solutions</h3>
                    <p class="text-gray-600">Environmentally friendly power distribution systems for modern farming.</p>
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
                        <li><a href="services.php" class="text-gray-400 hover:text-white">Services</a></li>
                        <li><a href="about.php" class="text-gray-400 hover:text-white">About</a></li>
                        <li><a href="contact.php" class="text-gray-400 hover:text-white">Contact</a></li>
                        <li><a href="chatbot.php" class="text-gray-400 hover:text-white">AI Assistant</a></li>
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

    <!-- Floating Chat Button -->
    <div id="chat-button" class="fixed bottom-6 right-6 w-16 h-16 bg-green-600 rounded-full flex items-center justify-center shadow-lg cursor-pointer hover:bg-green-700 transition-all z-50">
        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
        </svg>
    </div>

    <!-- Chat Window - Hidden by default -->
    <div id="chat-window" class="fixed bottom-6 right-6 w-80 md:w-96 bg-white rounded-lg shadow-xl z-50 overflow-hidden flex flex-col max-h-[32rem] hidden">
        <!-- Chat Header -->
        <div class="bg-green-600 text-white p-4 flex justify-between items-center">
            <div class="flex items-center">
                <span class="text-lg font-semibold">AgriBuddy</span>
                <span class="ml-2 bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Online</span>
            </div>
            <button id="close-chat" class="text-white hover:text-green-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <!-- Chat Messages -->
        <div id="chat-messages" class="flex-1 p-4 overflow-y-auto space-y-4">
            <!-- Bot Welcome Message -->
            <div class="flex items-start">
                <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white mr-2 flex-shrink-0">
                    <span>🤖</span>
                </div>
                <div class="bg-gray-100 rounded-lg p-3 max-w-[85%]">
                    <p class="text-sm">Hello! I'm your AgriPower Assistant. How can I help you with your farming or electrical needs today?</p>
                </div>
            </div>
            
            <div class="flex items-start">
                <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white mr-2 flex-shrink-0">
                    <span>🤖</span>
                </div>
                <div class="bg-gray-100 rounded-lg p-3 max-w-[85%]">
                    <p class="text-sm">You can ask me about irrigation systems, power solutions, or visit our <a href="chatbot.php" class="text-green-600 hover:underline">full AI assistant page</a> for more detailed help!</p>
                </div>
            </div>
        </div>
        
        <!-- Chat Input -->
        <form id="chat-form" class="border-t border-gray-200 p-3">
            <div class="flex items-center">
                <input type="text" id="user-message" placeholder="Type your message..." class="flex-1 border border-gray-300 rounded-l-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500">
                <button type="submit" class="bg-green-600 text-white py-2 px-4 rounded-r-lg hover:bg-green-700 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </button>
            </div>
            <div id="typing-indicator" class="text-sm text-gray-500 mt-1 ml-2 hidden">
                <span>AgriBuddy is typing...</span>
            </div>
        </form>
    </div>

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

        // Chat functionality
        const chatButton = document.getElementById('chat-button');
        const chatWindow = document.getElementById('chat-window');
        const closeChat = document.getElementById('close-chat');
        const chatForm = document.getElementById('chat-form');
        const userMessageInput = document.getElementById('user-message');
        const chatMessages = document.getElementById('chat-messages');

        // Toggle chat window
        chatButton.addEventListener('click', () => {
            chatWindow.classList.remove('hidden');
            chatButton.classList.add('hidden');
            userMessageInput.focus();
        });

        closeChat.addEventListener('click', () => {
            chatWindow.classList.add('hidden');
            chatButton.classList.remove('hidden');
        });

        // Handle form submission
        chatForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const message = userMessageInput.value.trim();
            
            if (message) {
                // Add user message
                addMessage(message, 'user');
                userMessageInput.value = '';
                
                // Show typing indicator
                const typingIndicator = document.getElementById('typing-indicator');
                if (typingIndicator) typingIndicator.classList.remove('hidden');
                
                // For quick testing, use demo responses
                const demoResponses = {
                    'hello': 'Hello! How can I help you with agricultural power solutions today?',
                    'hi': 'Hi there! I\'m AgriBuddy, your agricultural assistant. What can I help you with?',
                    'how can i improve irrigation efficiency?': 'You can improve irrigation efficiency by implementing drip irrigation systems, using soil moisture sensors, scheduling irrigation based on weather forecasts, and maintaining your equipment regularly.',
                    'what are the benefits of solar power for farming?': 'Solar power offers numerous benefits for farming including reduced energy costs, independence from the grid, environmental sustainability, low maintenance, long-term reliability, and potential government incentives or tax credits.',
                    'how do i troubleshoot power issues in my farm equipment?': 'To troubleshoot power issues: 1) Check all connections and wiring, 2) Inspect fuses and circuit breakers, 3) Test voltage at outlets, 4) Look for signs of damage or wear, and 5) Ensure proper grounding. For persistent issues, consider a professional electrical audit.',
                    'what government subsidies are available for agricultural power systems?': 'Various government subsidies are available including USDA Rural Energy for America Program (REAP), Environmental Quality Incentives Program (EQIP), state-specific renewable energy incentives, and tax credits for solar installations. Contact your local agricultural extension office for specific programs in your area.'
                };
                
                // Check for demo responses (case-insensitive)
                const lowerCaseMessage = message.toLowerCase();
                let responseFound = false;
                
                for (const key in demoResponses) {
                    if (lowerCaseMessage.includes(key)) {
                        setTimeout(() => {
                            if (typingIndicator) typingIndicator.classList.add('hidden');
                            addMessage(demoResponses[key], 'bot');
                        }, 1000);
                        responseFound = true;
                        break;
                    }
                }
                
                // If no demo response matches, use the API via process_chat.php
                if (!responseFound) {
                    // Create FormData object
                    const formData = new FormData();
                    formData.append('user_message', message);
                    formData.append('ajax', '1');
                    
                    // Fetch API call
                    fetch('process_chat.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (typingIndicator) typingIndicator.classList.add('hidden');
                        if (data && data.response) {
                            addMessage(data.response, 'bot');
                        } else {
                            addMessage("I'm sorry, I couldn't understand your question. Please try asking in a different way.", 'bot');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        if (typingIndicator) typingIndicator.classList.add('hidden');
                        
                        // If API fails, use a fallback response based on keywords
                        const fallbackResponse = getFallbackResponse(message);
                        addMessage(fallbackResponse, 'bot');
                    });
                }
            }
        });

        // Function to get a fallback response based on keywords
        function getFallbackResponse(message) {
            const lowerMessage = message.toLowerCase();
            
            if (lowerMessage.includes('irrigation')) {
                return "Irrigation is essential for agriculture. Our smart irrigation solutions can help optimize water usage and improve crop yields. Would you like to learn more about our specific irrigation systems?";
            } else if (lowerMessage.includes('solar') || lowerMessage.includes('power')) {
                return "We offer advanced solar power solutions for farms. These systems can reduce your energy costs significantly while providing sustainable power. Would you like more details?";
            } else if (lowerMessage.includes('cost') || lowerMessage.includes('price')) {
                return "Our pricing varies based on your specific requirements. Please visit our full AI assistant page or contact our team directly for a personalized quote.";
            } else if (lowerMessage.includes('equipment') || lowerMessage.includes('machinery')) {
                return "Properly powered farm equipment is crucial for efficient operations. We provide reliable power solutions for all types of agricultural machinery. What specific equipment are you looking to power?";
            } else {
                return "I'd be happy to help with your question about '" + message + "'. For a more detailed discussion, you can visit our <a href='chatbot.php' class='text-green-600 hover:underline'>full AI assistant page</a> or contact our experts directly.";
            }
        }

        // Add message to chat with typing effect
        function addMessage(message, sender) {
            const messageDiv = document.createElement('div');
            
            if (sender === 'user') {
                messageDiv.className = 'flex items-start justify-end my-2';
                messageDiv.innerHTML = `
                    <div class="bg-green-100 rounded-lg p-3 max-w-[85%]">
                        <p class="text-sm">${message}</p>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white ml-2 flex-shrink-0">
                        <span>👤</span>
                    </div>
                `;
                chatMessages.appendChild(messageDiv);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            } else {
                // For bot message, create container first
                messageDiv.className = 'flex items-start my-2';
                messageDiv.innerHTML = `
                    <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white mr-2 flex-shrink-0">
                        <span>🤖</span>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-3 max-w-[85%]">
                        <p class="text-sm typing-text"></p>
                    </div>
                `;
                chatMessages.appendChild(messageDiv);
                chatMessages.scrollTop = chatMessages.scrollHeight;
                
                // Get the paragraph element for typing effect
                const textElement = messageDiv.querySelector('.typing-text');
                
                // Apply typing effect with significantly increased speed
                typeText(textElement, message);
            }
        }
        
        // Function to create typing effect with significantly increased speed
        function typeText(element, text, index = 0) {
            // Much faster typing speed
            const baseSpeed = 3; // drastically reduced for very fast typing
            const variableSpeed = Math.random() * 7; // minimal variation for consistent speed
            const speed = baseSpeed + variableSpeed;
            
            // Process multiple characters per iteration for even faster typing
            const charsPerIteration = 3; // process 3 characters at once
            
            if (index < text.length) {
                if (text[index] === '<') {
                    // If HTML tag is encountered, find the closing '>' and add whole tag at once
                    const closeTagIndex = text.indexOf('>', index);
                    if (closeTagIndex !== -1) {
                        element.innerHTML += text.substring(index, closeTagIndex + 1);
                        index = closeTagIndex + 1;
                    }
                } else {
                    // Add multiple characters at once, but don't exceed text length
                    const endIndex = Math.min(index + charsPerIteration, text.length);
                    element.innerHTML += text.substring(index, endIndex);
                    index = endIndex;
                }
                
                chatMessages.scrollTop = chatMessages.scrollHeight;
                setTimeout(() => typeText(element, text, index), speed);
            }
        }
    </script>
</body>
</html> 