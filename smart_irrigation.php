<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AgriPower - Smart Irrigation Control Panel</title>
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
<a href="index.php" class="hover:text-green-200 transition">Home</a>
<a href="services.php" class="hover:text-green-200 transition underline">Services</a>
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
            </div>
        </div>
    </div>
</nav>

<div class="container mx-auto py-24 px-4">

    <!-- Change Farm Settings Section -->
    <div id="farmSettingsSection" class="bg-white p-8 rounded-lg shadow-md mb-12" data-aos="fade-up">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-6">Change Farm Settings</h1>
        <div class="mb-4">
            <label for="farmId" class="block text-gray-700 text-sm font-bold mb-2">Select Your Farm To Modify Settings:</label>
            <select id="farmId" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="0">0 (FarmID: 0)</option>
                <!-- You could dynamically populate these options later -->
            </select>
        </div>
        <div class="mb-4">
            <label for="farmLocation" class="block text-gray-700 text-sm font-bold mb-2">Farm Location:</label>
            <input type="text" id="farmLocation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="crop" class="block text-gray-700 text-sm font-bold mb-2">Crop:</label>
            <select id="crop" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="" disabled selected>Select Crop</option> <!-- Default placeholder -->
                <option value="wheat">Wheat</option>
                <option value="rice">Rice</option>
                <option value="sugarcane">Sugarcane</option>
                <option value="mustard">Mustard</option>
                <option value="pulses">Pulses (Lentil, Chickpea)</option>
                <option value="maize">Maize (Corn)</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="motorCapacity" class="block text-gray-700 text-sm font-bold mb-2">Motor Capacity (in kW):</label>
            <input type="number" id="motorCapacity" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="landArea" class="block text-gray-700 text-sm font-bold mb-2">Land Area (in acres):</label>
            <input type="number" id="landArea" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-6">
            <label for="cropSowingDate" class="block text-gray-700 text-sm font-bold mb-2">Date of Crop Sowing:</label>
            <input type="date" id="cropSowingDate" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <button id="saveSettingsBtn" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
            Save Changes
        </button>
    </div>

    <!-- Smart Irrigation Control Panel Section -->
    <div id="controlPanelSection" class="mb-12 hidden" data-aos="fade-right">
        <div class="bg-white p-8 rounded-lg shadow-md mb-6">
            <div id="weather-summary">
                <h3 class="text-xl font-semibold mb-2">Weather Forecast</h3>
                <p>Loading weather data...</p>
            </div>
            <div id="detailed-forecast" class="hidden mt-2">
                <!-- Detailed forecast will be loaded here -->
            </div>
            <button id="toggle-forecast-btn" class="text-green-600 hover:underline hidden">View Detailed Forecast</button>
        </div>

        <h1 class="text-4xl font-bold text-center text-gray-800 mb-12" data-aos="fade-up">Smart Irrigation Control Panel</h1>

        <div class="bg-white p-8 rounded-lg shadow-md mb-12">
            <div class="flex justify-between items-center mb-6">
                <span class="text-lg font-semibold">Automation System:</span>
                <div>
                    <button class="bg-green-600 text-white px-4 py-2 rounded-lg mr-2">Turn ON</button>
                    <button class="bg-red-600 text-white px-4 py-2 rounded-lg">Turn OFF</button>
                </div>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg flex justify-between items-center mb-4">
                <span>Sensor 0:</span>
                <input type="text" class="w-1/4 p-2 border rounded-lg">
                <span>Sensor 1:</span>
                <input type="text" class="w-1/4 p-2 border rounded-lg">
            </div>
            <div class="bg-gray-100 p-4 rounded-lg flex justify-between items-center mb-4">
                <span>Switch 0: Light</span>
                <input type="text" class="w-1/2 p-2 border rounded-lg" placeholder="Enter time in seconds">
                <button class="bg-red-600 text-white px-4 py-2 rounded-lg">Turn OFF</button>
                <button class="bg-green-600 text-white px-4 py-2 rounded-lg">Turn ON</button>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg flex justify-between items-center">
                <span>Switch 1: Motor</span>
                <input type="text" class="w-1/2 p-2 border rounded-lg" placeholder="Enter time in seconds">
                <button class="bg-red-600 text-white px-4 py-2 rounded-lg">Turn OFF</button>
                <button class="bg-green-600 text-white px-4 py-2 rounded-lg">Turn ON</button>
            </div>
        </div>

        <h2 class="text-3xl font-bold text-center text-gray-800 mb-12" data-aos="fade-up">Smart Irrigation System Overview</h2>

        <div class="bg-white p-8 rounded-lg shadow-md mb-12" data-aos="fade-right">
            <h3 class="text-2xl font-bold mb-4">Components Overview</h3>
            <ul>
                <?php
                $components = [
                    "NodeMCU ESP8266" => "Acts as the central controller and communicates with sensors and actuators.",
                    "12V Servo Motor" => "Used for controlling valves or gates.",
                    "12V DC Motor" => "Powers pumps for water distribution.",
                    "12V Stepper Motor" => "Provides precise control for rotating components.",
                    "5V Moisture Sensor" => "Measures soil moisture levels.",
                    "5V Ultrasonic Buzzer" => "Alerts for specific conditions.",
                    "Relay Modules" => "Control high voltage devices with low voltage signals.",
                    "Power Supply" => "12V DC and 5V sources for powering components."
                ];
                foreach ($components as $component => $description) {
                    echo "<li><b>$component:</b> $description</li>";
                }
                ?>
            </ul>
        </div>

        <div class="bg-white p-8 rounded-lg shadow-md mb-12" data-aos="fade-right">
            <h3 class="text-2xl font-bold mb-4">System Design</h3>
            <ul>
                <?php
                $system_design = [
                    "Power Management" => "Use a 12V DC power source for motors and relays. Use a 5V source for the NodeMCU, sensors, and buzzers. Ensure proper voltage regulation to avoid damage to components.",
                    "Sensor Integration" => "Connect moisture sensors to the NodeMCU to monitor soil moisture. Use the data to determine when to activate the irrigation system.",
                    "Actuator Control" => "Use relay modules to control the servo, DC, and stepper motors. Servo motors can open/close valves based on moisture readings. DC motors can pump water when needed. Stepper motors can adjust the position of irrigation equipment.",
                    "Communication and Control" => "Program the NodeMCU to read sensor data and control actuators. Implement Wi-Fi connectivity for remote monitoring and control. Use a web interface or mobile app to manage the system.",
                    "Alert System" => "Use ultrasonic buzzers to alert for low water levels or system faults."
                ];
                foreach ($system_design as $design => $description) {
                    echo "<li><b>$design:</b> $description</li>";
                }
                ?>
            </ul>
        </div>

        <div class="bg-white p-8 rounded-lg shadow-md mb-12" data-aos="fade-right">
            <h3 class="text-2xl font-bold mb-4">Future Planning</h3>
            <ul>
                <?php
                $future_planning = [
                    "Scalability" => "Design the system to easily add more sensors and actuators.",
                    "Data Logging" => "Implement data logging for analysis and optimization.",
                    "AI Integration" => "Use machine learning to predict irrigation needs based on weather forecasts and historical data.",
                    "Energy Efficiency" => "Optimize the system to minimize power consumption."
                ];
                foreach ($future_planning as $plan => $description) {
                    echo "<li><b>$plan:</b> $description</li>";
                }
                ?>
            </ul>
        </div>

        <!-- Button to edit settings -->
        <div class="text-center">
            <button id="editSettingsBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mt-4">Edit Farm Settings</button>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-gray-800 text-white py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4">AgriPower</h3>
                <p>Leading the way in sustainable agricultural power solutions.</p>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="index.php" class="hover:underline">Home</a></li>
                    <li><a href="services.php" class="hover:underline">Services</a></li>
                    <li><a href="about.php" class="hover:underline">About</a></li>
                    <li><a href="contact.php" class="hover:underline">Contact</a></li>
                    <li><a href="chatbot.php" class="hover:underline">AI Assistant</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4">Contact Us</h3>
                <p>info@agripower.com</p>
                <p>+1 (555) 123-4567</p>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4">Follow Us</h3>
                <div class="flex space-x-4">
                    <a href="#" class="hover:text-gray-400">Facebook</a>
                    <a href="#" class="hover:text-gray-400">Twitter</a>
                    <a href="#" class="hover:text-gray-400">LinkedIn</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="smart_irrigation.js"></script>
</body>
</html>