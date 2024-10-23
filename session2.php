<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Info</title>
</head>
<body>

<h1>Session Information</h1>

<?php
// Display the session name and ID
echo "<p>Session Name: " . session_name() . "</p>";
echo "<p>Session ID: " . session_id() . "</p>";

// Check if session variables are set before displaying
if (isset($_SESSION["name"]) && isset($_SESSION["session1d"])) {
    echo "<p>Session Variable 1: " . htmlspecialchars($_SESSION["name"]) . "</p>";
    echo "<p>Session Variable 2: " . htmlspecialchars($_SESSION["session1d"]) . "</p>";
} else {
    echo "<p>No session variables are set.</p>";
}
?>

<a href="sessiondestroy.php">Logout</a>

</body>
</html>
