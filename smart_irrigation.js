document.addEventListener('DOMContentLoaded', function() {
AOS.init();
const farmSettingsSection = document.getElementById('farmSettingsSection');
const controlPanelSection = document.getElementById('controlPanelSection');
const saveSettingsBtn = document.getElementById('saveSettingsBtn');
const weatherSummaryDiv = document.getElementById('weather-summary');
const detailedForecastDiv = document.getElementById('detailed-forecast');
const toggleForecastButton = document.getElementById('toggle-forecast-btn');

// Function to load farm settings from localStorage
function loadFarmSettings() {
    const settings = localStorage.getItem('farmSettings');
    if (settings) {
        return JSON.parse(settings);
    }
    return null;
}

// Function to display farm settings in the form
function displayFarmSettings(settings) {
    if (settings) {
        document.getElementById('farmId').value = settings.farmId || '0';
        document.getElementById('farmLocation').value = settings.farmLocation || '';
        document.getElementById('crop').value = settings.crop || '';
        document.getElementById('motorCapacity').value = settings.motorCapacity || '';
        document.getElementById('landArea').value = settings.landArea || '';
        document.getElementById('cropSowingDate').value = settings.cropSowingDate || '';
    }
}

// Function to show the control panel and hide the settings form
function showControlPanel() {
    farmSettingsSection.classList.add('hidden');
    controlPanelSection.classList.remove('hidden');
    const savedSettingsForWeather = loadFarmSettings();
    if (savedSettingsForWeather && savedSettingsForWeather.farmLocation) {
        updateWeatherForecast(savedSettingsForWeather.farmLocation);
    }
}

// Function to show the settings form and hide the control panel
function showFarmSettingsForm() {
    controlPanelSection.classList.add('hidden');
    farmSettingsSection.classList.remove('hidden');
}

// Check if farm settings exist on page load
const savedSettings = loadFarmSettings();
if (savedSettings) {
    showControlPanel();
    displayFarmSettings(savedSettings); // Optionally display for potential editing
} else {
    showFarmSettingsForm();
}

// Event listener for saving farm settings
saveSettingsBtn.addEventListener('click', function() {
    const farmId = document.getElementById('farmId').value;
    const farmLocation = document.getElementById('farmLocation').value;
    const crop = document.getElementById('crop').value;
    const motorCapacity = document.getElementById('motorCapacity').value;
    const landArea = document.getElementById('landArea').value;
    const cropSowingDate = document.getElementById('cropSowingDate').value;

    const settings = {
        farmId: farmId,
        farmLocation: farmLocation,
        crop: crop,
        motorCapacity: motorCapacity,
        landArea: landArea,
        cropSowingDate: cropSowingDate
    };

    localStorage.setItem('farmSettings', JSON.stringify(settings));
    showControlPanel();
});

const editSettingsBtn = document.getElementById('editSettingsBtn');
if (editSettingsBtn) {
    editSettingsBtn.addEventListener('click', () => {
        const savedSettingsForEdit = loadFarmSettings();
        displayFarmSettings(savedSettingsForEdit);
        showFarmSettingsForm();
    });
}

function updateWeatherForecast(location) {
    // Replace this with your actual API call and data handling
    fetchWeatherData(location)
        .then(data => {
            if (weatherSummaryDiv) {
                weatherSummaryDiv.innerHTML = `<h3 class="text-xl font-semibold mb-2">Weather Forecast</h3><p>Today: ${data.todaySummary}, High ${data.highTemp}°C, Low ${data.lowTemp}°C. ${data.rainChance}% chance of rain.</p>`;
            }
            if (detailedForecastDiv && data.detailedForecast) {
                let detailedHTML = '<h4 class="font-semibold mt-2">Next 3 Days:</h4><ul class="list-disc ml-5">';
                data.detailedForecast.forEach(day => {
                    detailedHTML += `<li>${day.date}: ${day.condition}, High ${day.maxTemp}°C, Low ${day.minTemp}°C, Rain: ${day.precipitation}%</li>`;
                });
                detailedHTML += '</ul>';
                detailedForecastDiv.innerHTML = detailedHTML;
            }
            if (toggleForecastButton) {
                toggleForecastButton.classList.remove('hidden');
            }
        })
        .catch(error => {
            console.error("Error fetching weather data:", error);
            if (weatherSummaryDiv) {
                weatherSummaryDiv.innerHTML = '<h3 class="text-xl font-semibold mb-2">Weather Forecast</h3><p class="text-red-500">Unable to fetch weather data.</p>';
            }
            if (toggleForecastButton) {
                toggleForecastButton.classList.add('hidden');
            }
            if (detailedForecastDiv) {
                detailedForecastDiv.innerHTML = '';
            }
        });
}

// Dummy function for fetching weather data (replace with your actual API call)
function fetchWeatherData(location) {
    return new Promise((resolve) => {
        // Simulate an API response
        setTimeout(() => {
            resolve({
                todaySummary: "Partly Cloudy",
                highTemp: 27,
                lowTemp: 19,
                rainChance: 25,
                detailedForecast: [
                    { date: "Tomorrow", condition: "Rainy", maxTemp: 24, minTemp: 17, precipitation: 70 },
                    { date: "Day After", condition: "Sunny", maxTemp: 29, minTemp: 20, precipitation: 5 },
                    { date: "Two Days After", condition: "Mostly Cloudy", maxTemp: 26, minTemp: 18, precipitation: 30 }
                ]
            });
        }, 1500); // Simulate network delay
    });
}

if (toggleForecastButton && detailedForecastDiv) {
    toggleForecastButton.addEventListener('click', () => {
        detailedForecastDiv.classList.toggle('hidden');
        toggleForecastButton.textContent = detailedForecastDiv.classList.contains('hidden') ? 'View Detailed Forecast' : 'Hide Detailed Forecast';
    });
}
});