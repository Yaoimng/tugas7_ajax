<?php
// Allow some time for the "processing" effect to be noticeable
sleep(1);

// Set header to return JSON response
header('Content-Type: application/json');

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data and sanitize inputs
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
    $message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';
    
    // Validate inputs
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }
    
    if (empty($message)) {
        $errors[] = "Message is required.";
    }
    
    // If there are validation errors
    if (!empty($errors)) {
        echo json_encode([
            'status' => 'error',
            'message' => implode('<br>', $errors)
        ]);
        exit;
    }
    
    // Process the form data (in a real application, you might save to a database or send an email)
    // For example, you could save to a file:
    // file_put_contents('submissions.txt', "Name: $name, Email: $email, Message: $message\n", FILE_APPEND);
    
    // In a real application, you would perform your actual processing here
    // For example:
    /*
    $to = "your-email@example.com";
    $subject = "New Form Submission";
    $body = "Name: $name\nEmail: $email\nMessage: $message";
    $headers = "From: $email";
    
    mail($to, $subject, $body, $headers);
    */
    
    // Return success response
    echo json_encode([
        'status' => 'success',
        'message' => "Thank you, $name! Your message has been received successfully."
    ]);
    
} else {
    // If not POST request, return an error
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method.'
    ]);
}
?>