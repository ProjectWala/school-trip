<?php
// Step 1: Initialize the session to access existing session data
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Step 2: Unset all of the session variables
$_SESSION = [];

// Step 3: Delete the session cookie to fully clear the browser footprint
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000,
        $params["path"], 
        $params["domain"], 
        $params["secure"], 
        $params["httponly"]
    );
}

// Step 4: Destroy the session data stored on the server
session_destroy();

// Step 5: Redirect the user back to the login or home page
header("Location: ../login.php");
exit(); // Always use exit() after header redirection to stop script execution
?>
