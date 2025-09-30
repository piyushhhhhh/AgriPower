<?php
require_once 'session_handler.php';
requireLogin();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $service_type = trim($_POST['service_type']);
    $description = trim($_POST['description']);
    $preferred_date = trim($_POST['preferred_date']);
    $preferred_time = trim($_POST['preferred_time']);
    
    // Validate service type
    $valid_service_types = ['routine_inspection', 'equipment_repair', 'system_upgrade', 'emergency_service', 'preventive_maintenance'];
    if (!in_array($service_type, $valid_service_types)) {
        $_SESSION['error'] = "Invalid service type selected.";
        header("Location: maintenance.php");
        exit();
    }
    
    // Validate preferred time
    $valid_times = ['morning', 'afternoon', 'evening'];
    if (!in_array($preferred_time, $valid_times)) {
        $_SESSION['error'] = "Invalid time slot selected.";
        header("Location: maintenance.php");
        exit();
    }
    
    // Validate preferred date
    $date = DateTime::createFromFormat('Y-m-d', $preferred_date);
    if (!$date || $date->format('Y-m-d') !== $preferred_date) {
        $_SESSION['error'] = "Invalid date format.";
        header("Location: maintenance.php");
        exit();
    }
    
    // Check if date is not in the past
    if ($date < new DateTime()) {
        $_SESSION['error'] = "Please select a future date.";
        header("Location: maintenance.php");
        exit();
    }
    
    // Insert maintenance request
    $stmt = $conn->prepare("INSERT INTO maintenance_requests (user_id, service_type, description, preferred_date, preferred_time) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $_SESSION['user_id'], $service_type, $description, $preferred_date, $preferred_time);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Maintenance request submitted successfully.";
        
        // Send email notification (in a real application)
        // mail('maintenance@agripower.com', 'New Maintenance Request', "A new maintenance request has been submitted.\n\nService Type: $service_type\nDate: $preferred_date\nTime: $preferred_time");
        
        header("Location: maintenance.php");
        exit();
    } else {
        $_SESSION['error'] = "Failed to submit maintenance request. Please try again.";
        header("Location: maintenance.php");
        exit();
    }
} else {
    header("Location: maintenance.php");
    exit();
}
?> 