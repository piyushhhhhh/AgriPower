<?php
header('Content-Type: application/json');

// Function to get a response from the OpenRouter API
function getAIChatResponse($userMessage) {
    $apiKey = "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";
    $url = "https://openrouter.ai/api/v1/chat/completions";
    
    $headers = [
        "Content-Type: application/json",
        "Authorization: Bearer " . $apiKey,
        "HTTP-Referer: https://agripower.com", // Replace with your actual site URL
        "X-Title: AgriPower" // Your site name
    ];
    
    $data = [
        "model" => "deepseek/deepseek-chat-v3-0324:free",
        "messages" => [
            [
                "role" => "system",
                "content" => "You are AgriBuddy, an AI assistant for AgriPower, specializing in agricultural power solutions, irrigation systems, and sustainable farming practices. Keep responses helpful, concise, and focused on farming and agricultural power systems."
            ],
            [
                "role" => "user",
                "content" => $userMessage
            ]
        ]
    ];
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        return "I'm sorry, I encountered an error while processing your request. Please try again later.";
    }
    
    $responseData = json_decode($response, true);
    
    if (isset($responseData['choices'][0]['message']['content'])) {
        return $responseData['choices'][0]['message']['content'];
    } else {
        return "I'm sorry, I couldn't generate a response at this time. Please try again later.";
    }
}

// Handle the AJAX request
if (isset($_POST['user_message']) && !empty($_POST['user_message'])) {
    $userMessage = htmlspecialchars($_POST['user_message']);
    
    // For quick testing, you can use demo responses instead of API calls
    $demoResponses = [
        'hello' => 'Hello! How can I help you with agricultural power solutions today?',
        'hi' => 'Hi there! I\'m AgriBuddy, your agricultural assistant. What questions do you have about farming or power systems?'
    ];
    
    // Check for demo responses first (case-insensitive)
    $lowerCaseUserMessage = strtolower($userMessage);
    if (array_key_exists($lowerCaseUserMessage, $demoResponses)) {
        echo json_encode(['response' => $demoResponses[$lowerCaseUserMessage]]);
        exit;
    }
    
    // If no demo response matches, call the API
    $botResponse = getAIChatResponse($userMessage);
    echo json_encode(['response' => $botResponse]);
} else {
    echo json_encode(['error' => 'No message provided']);
}
?> 