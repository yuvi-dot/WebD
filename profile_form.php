<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: Login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Save user input in session
    $_SESSION['is_student'] = $_POST['is_student'];
    $_SESSION['additional_info'] = $_POST['additional_info'];
    
    // Save user input in cookies (optional)
    setcookie("is_student", $_POST['is_student'], time() + 3600); // 1 hour
    setcookie("additional_info", $_POST['additional_info'], time() + 3600); // 1 hour
    
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Form</title>
    <link rel="stylesheet" href="Login.css">
</head>
<body>
    <form action="profile_form.php" method="POST">
        <h1>Profile Form</h1>
        <label>Are you a student?</label>
        <select name="is_student" required>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select>
        <label>Additional Information</label>
        <textarea name="additional_info" rows="4" required></textarea>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
