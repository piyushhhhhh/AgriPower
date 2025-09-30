<?php
session_start();
require_once 'config.php';

// Function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Function to check and validate remember me token
function checkRememberMe() {
    global $conn;
    
    if (!isLoggedIn() && isset($_COOKIE['remember_token'])) {
        $token = $_COOKIE['remember_token'];
        
        // Get token from database
        $stmt = $conn->prepare("SELECT user_id, expires_at FROM remember_tokens WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $token_data = $result->fetch_assoc();
            
            // Check if token is expired
            if (strtotime($token_data['expires_at']) > time()) {
                // Get user data
                $stmt = $conn->prepare("SELECT id, first_name, last_name FROM users WHERE id = ?");
                $stmt->bind_param("i", $token_data['user_id']);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows === 1) {
                    $user = $result->fetch_assoc();
                    
                    // Set session variables
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
                    
                    return true;
                }
            }
            
            // Token is expired or user not found, remove it
            $stmt = $conn->prepare("DELETE FROM remember_tokens WHERE token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            
            setcookie('remember_token', '', time() - 3600, '/', '', true, true);
        }
    }
    
    return false;
}

// Function to require login
function requireLogin() {
    if (!isLoggedIn() && !checkRememberMe()) {
        header("Location: login.php");
        exit();
    }
}

// Function to create remember me token
function createRememberToken($user_id) {
    global $conn;
    
    $token = bin2hex(random_bytes(32));
    $expires = time() + (30 * 24 * 60 * 60); // 30 days
    
    // Store token in database
    $stmt = $conn->prepare("INSERT INTO remember_tokens (user_id, token, expires_at) VALUES (?, ?, FROM_UNIXTIME(?))");
    $stmt->bind_param("isi", $user_id, $token, $expires);
    
    if ($stmt->execute()) {
        // Set cookie
        setcookie('remember_token', $token, $expires, '/', '', true, true);
        return true;
    }
    
    return false;
}

// Function to clean up expired tokens
function cleanupExpiredTokens() {
    global $conn;
    
    $conn->query("DELETE FROM remember_tokens WHERE expires_at < NOW()");
}

// Clean up expired tokens periodically (1% chance on each request)
if (rand(1, 100) === 1) {
    cleanupExpiredTokens();
}
?> 