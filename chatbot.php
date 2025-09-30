<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgriPower - AI Farming Assistant</title>
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
        .chat-message {
            transition: all 0.3s ease;
        }
        .user-message {
            background-color: #e2f3eb;
        }
        .bot-message {
            background-color: #f3f4f6;
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
                    <a href="index.php" class="hover:text-green-200 transition">Home</a>
                    <a href="services.php" class="hover:text-green-200 transition">Services</a>
                    <a href="about.php" class="hover:text-green-200 transition">About</a>
                    <a href="contact.php" class="hover:text-green-200 transition">Contact</a>
                    <a href="chatbot.php" class="hover:text-green-200 transition underline">AI Assistant</a>
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
                    <a href="chatbot.php" class="block px-3 py-2 bg-green-700 rounded">AI Assistant</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Chat Section -->
    <section class="pt-28 pb-12 px-4">
        <div class="container mx-auto max-w-4xl">
            <div class="text-center mb-10" data-aos="fade-up">
                <h1 class="text-4xl font-bold text-gray-800 mb-4">AgriBuddy AI Assistant</h1>
                <p class="text-xl text-gray-600">Your virtual farming expert. Ask any agriculture or power-related questions!</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up">
                <!-- Chat Messages Container -->
                <div id="chat-messages" class="h-96 overflow-y-auto p-4 space-y-4">
                    <!-- Bot welcome message -->
                    <div class="chat-message bot-message p-3 rounded-lg max-w-3/4">
                        <div class="flex items-start">
                            <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white mr-3">
                                <span>🤖</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">AgriBuddy</p>
                                <p class="text-gray-700">Hello! I'm your AgriPower Assistant. How can I help you with your farming or electrical needs today?</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chat Input Form -->
                <form id="chat-form" class="border-t border-gray-200 p-4">
                    <div class="flex items-center">
                        <input type="text" id="user-message" name="user_message" placeholder="Ask a question about farming or power systems..." 
                               class="flex-1 rounded-l-lg border border-gray-300 py-2 px-4 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-r-lg transition duration-300">
                            <span>Send</span>
                        </button>
                    </div>
                    <div id="typing-indicator" class="text-sm text-gray-500 mt-1 ml-2 hidden">
                        <span>AgriBuddy is typing...</span>
                    </div>
                </form>
            </div>

            <!-- Suggested Questions -->
            <div class="mt-10" data-aos="fade-up" data-aos-delay="200">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Suggested Questions</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <button onclick="askQuestion('How can I improve irrigation efficiency?')" class="text-left p-3 bg-gray-100 hover:bg-green-100 rounded-lg transition">
                        How can I improve irrigation efficiency?
                    </button>
                    <button onclick="askQuestion('What are the benefits of solar power for farming?')" class="text-left p-3 bg-gray-100 hover:bg-green-100 rounded-lg transition">
                        What are the benefits of solar power for farming?
                    </button>
                    <button onclick="askQuestion('How do I troubleshoot power issues in my farm equipment?')" class="text-left p-3 bg-gray-100 hover:bg-green-100 rounded-lg transition">
                        How do I troubleshoot power issues in my farm equipment?
                    </button>
                    <button onclick="askQuestion('What government subsidies are available for agricultural power systems?')" class="text-left p-3 bg-gray-100 hover:bg-green-100 rounded-lg transition">
                        What government subsidies are available for agricultural power systems?
                    </button>
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

        // Chat functionality with proper AJAX implementation
        document.getElementById('chat-form').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission
            
            const userMessageInput = document.getElementById('user-message');
            const userMessage = userMessageInput.value.trim();
            
            if (userMessage) {
                // Display user message
                addUserMessage(userMessage);
                userMessageInput.value = '';
                
                // Show typing indicator
                document.getElementById('typing-indicator').classList.remove('hidden');
                
                // Make AJAX request to get bot response
                fetchBotResponse(userMessage);
            }
        });

        // Function to add user message to chat
        function addUserMessage(message) {
            const userMessageHtml = `
                <div class="chat-message user-message p-3 rounded-lg max-w-3/4 ml-auto">
                    <div class="flex items-start justify-end">
                        <div class="text-right">
                            <p class="font-medium text-gray-800">You</p>
                            <p class="text-gray-700">${message}</p>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white ml-3">
                            <span>👤</span>
                        </div>
                    </div>
                </div>
            `;
            
            document.getElementById('chat-messages').insertAdjacentHTML('beforeend', userMessageHtml);
            scrollToBottom();
        }

        // Function to add bot message to chat with typing effect
        function addBotMessage(message) {
            // First create the message container with empty text
            const botMessageContainer = `
                <div class="chat-message bot-message p-3 rounded-lg max-w-3/4">
                    <div class="flex items-start">
                        <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white mr-3">
                            <span>🤖</span>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">AgriBuddy</p>
                            <p class="text-gray-700 typing-text"></p>
                        </div>
                    </div>
                </div>
            `;
            
            document.getElementById('chat-messages').insertAdjacentHTML('beforeend', botMessageContainer);
            
            // Get the most recently added typing-text element
            const typingElements = document.querySelectorAll('.typing-text');
            const textElement = typingElements[typingElements.length - 1];
            
            // Apply typing effect
            typeText(textElement, message);
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
                
                scrollToBottom();
                setTimeout(() => typeText(element, text, index), speed);
            }
        }

        // Function to fetch bot response
        function fetchBotResponse(userMessage) {
            // For testing without API calls
            const demoResponses = {
                'how can i improve irrigation efficiency?': 'You can improve irrigation efficiency by implementing drip irrigation systems, using soil moisture sensors, scheduling irrigation based on weather forecasts, and maintaining your equipment regularly.',
                'what are the benefits of solar power for farming?': 'Solar power offers numerous benefits for farming including reduced energy costs, independence from the grid, environmental sustainability, low maintenance, long-term reliability, and potential government incentives or tax credits.',
                'how do i troubleshoot power issues in my farm equipment?': 'To troubleshoot power issues: 1) Check all connections and wiring, 2) Inspect fuses and circuit breakers, 3) Test voltage at outlets, 4) Look for signs of damage or wear, and 5) Ensure proper grounding. For persistent issues, consider a professional electrical audit.',
                'what government subsidies are available for agricultural power systems?': 'Various government subsidies are available including USDA Rural Energy for America Program (REAP), Environmental Quality Incentives Program (EQIP), state-specific renewable energy incentives, and tax credits for solar installations. Contact your local agricultural extension office for specific programs in your area.'
            };

            // Check for demo responses first (case-insensitive)
            const lowerCaseUserMessage = userMessage.toLowerCase();
            for (const key in demoResponses) {
                if (lowerCaseUserMessage === key) {
                    setTimeout(() => {
                        document.getElementById('typing-indicator').classList.add('hidden');
                        addBotMessage(demoResponses[key]);
                    }, 1500); // Simulate API delay
                    return;
                }
            }

            // If no demo response matches, make the actual API call
            // Create form data for the request
            const formData = new FormData();
            formData.append('user_message', userMessage);
            formData.append('ajax', '1');
            
            // Send AJAX request to the server API endpoint
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
                document.getElementById('typing-indicator').classList.add('hidden');
                if (data && data.response) {
                    addBotMessage(data.response);
                } else {
                    addBotMessage("I'm sorry, I couldn't understand your question. Please try asking in a different way.");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('typing-indicator').classList.add('hidden');
                addBotMessage("I'm sorry, I encountered an error processing your request. Please try again later.");
            });
        }

        // Function to scroll chat to bottom
        function scrollToBottom() {
            const chatContainer = document.getElementById('chat-messages');
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        // Function to handle suggested questions
        function askQuestion(question) {
            document.getElementById('user-message').value = question;
            document.getElementById('chat-form').dispatchEvent(new Event('submit'));
        }
    </script>
</body>
</html> 