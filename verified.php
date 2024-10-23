<?php
session_start();

// Handle logout
if (isset($_POST['logout'])) {
    // Clear the session and cookies
    session_unset();
    session_destroy();
    setcookie('username', '', time() - 3600, '/'); // Expire the cookie
    header('Location: index.html');
    exit();
}

// Redirect to info.php if no user info is set
if (!isset($_SESSION['user_info'])) {
    header('Location: info.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verified Information</title>
    <link rel="stylesheet" href="Login.css">
</head>
<body>
    <div class="register">
        <h1>Verified Information</h1>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['user_info']['name']); ?></p>
        <p><strong>Education:</strong> <?php echo htmlspecialchars($_SESSION['user_info']['education']); ?></p>
        <p><strong>Profession:</strong> <?php echo htmlspecialchars($_SESSION['user_info']['profession']); ?></p>

        <form action="verified.php" method="POST" class="submit">
            <button type="submit" name="logout">Logout</button>
        </form>
    </div>
</body>
</html>
