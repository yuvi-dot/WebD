<?php
session_start();

// Redirect to info.php if no user info is set
if (!isset($_SESSION['user_info'])) {
    header('Location: info.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit'])) {
        // Redirect to info.php with existing data to edit
        header('Location: info.php');
        exit();
    }

    if (isset($_POST['verify'])) {
        header('Location: verified.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Information</title>
    <link rel="stylesheet" href="Login.css">
</head>
<body>
    <div class="register">
        <h1>Verify Information</h1>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['user_info']['name']); ?></p>
        <p><strong>Education:</strong> <?php echo htmlspecialchars($_SESSION['user_info']['education']); ?></p>
        <p><strong>Profession:</strong> <?php echo htmlspecialchars($_SESSION['user_info']['profession']); ?></p>

        <form action="verify.php" method="POST" class="submit">
            <button type="submit" name="edit">Edit</button>
            <button type="submit" name="verify">Verify</button>
        </form>
    </div>
</body>
</html>
