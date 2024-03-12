<?php
// logout.php
session_start(); // Start the session to access session variables

// Clear session data
session_unset(); // Remove all session variables
session_destroy(); // Destroy the session

// Redirect to index.php
header('Location: index.php');
exit(); // Ensure script execution ends here
