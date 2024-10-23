<?php
// Start the session
session_start();

// Remove all session variables
session_unset();

// Destroy the session
session_destroy();

// Provide feedback to the user
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Destroyed</title>
</head>
<body>

<h1>Session Destroyed</h1>

<p>All session variables have been cleared and the session has been destroyed.</p>

<p><a href="index.html">Return to Login Page</a></p>

</body>
</html>
