<?php
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$localhost = "localhost";
$db_User = "root"; 
$db_Password = ""; 
$db_Name = "codegenius";

// Create connection
$con = mysqli_connect($localhost, $db_User, $db_Password, $db_Name);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables
$error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Name = mysqli_real_escape_string($con, $_POST['Name']);
    $Password = mysqli_real_escape_string($con, $_POST['Password']);

    // Check if user exists
    $stmt = $con->prepare("SELECT * FROM login WHERE Name = ?");
    $stmt->bind_param("s", $Name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
    // User exists, check Password
    $row = $result->fetch_assoc();
    if (password_verify($Password, $row['Password'])) {
        // Correct Password, redirect to dashboard
        session_regenerate_id(true);
        $_SESSION['Name'] = $Name;
        header('Location: index.html');
        exit();
    } else {
        // Incorrect Password
        $error = "Incorrect Password.";
    }
} else {
    // User does not exist, register the user
    $hashed_Password = password_hash($Password, PASSWORD_DEFAULT);
    $insert_stmt = $con->prepare("INSERT INTO login (Name, Password) VALUES (?, ?)");
    $insert_stmt->bind_param("ss", $Name, $hashed_Password);
    
    if ($insert_stmt->execute()) {
        // Successfully registered, redirect to info.php
        session_regenerate_id(true);
        $_SESSION['Name'] = $Name; // Set session for the new user
        header('Location: info.php'); // Redirect to info.php
        exit();
    } else {
        // Error inserting data
        $error = "Error creating user: " . mysqli_error($con); // Debugging output
    }
}

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="Login.css">
</head>
<body>
    <form action="" method="POST" class="login">
        <h1>Login</h1>
        <?php if ($error): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <label for="Name">Name:</label>
        <input type="text" id="Name" name="Name" required>

        <label for="Password">Password:</label>
        <input type="password" id="Password" name="Password" required>

        <button type="submit">Login</button>
    </form>
</body>
</html>

<?php
mysqli_close($con); // Close the database connection
?>
