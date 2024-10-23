<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: Login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Welcome to Your Dashboard</h1>
        <a href="Logout.php">Logout</a>
    </header>
    
    <section>
        <h2>Your Information</h2>
        <p><strong>Are you a student?</strong> <?php echo $_SESSION['is_student']; ?></p>
        <p><strong>Additional Information:</strong> <?php echo $_SESSION['additional_info']; ?></p>
    </section>
</body>
</html>
