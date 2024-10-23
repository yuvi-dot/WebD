<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Database credentials
$localhost = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "codegenius";

// Create connection
$con = mysqli_connect($localhost, $db_username, $db_password, $db_name);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $education = mysqli_real_escape_string($con, $_POST['education']);
    $profession = mysqli_real_escape_string($con, $_POST['profession']);

    // Check if we are editing an existing record
    if (isset($_SESSION['user_info']['id'])) {
        // Update existing record
        $id = $_SESSION['user_info']['id']; // Use session-stored ID
        $update_query = "UPDATE form SET Name='$name', Education='$education', Profession='$profession' WHERE id='$id'";

        if (mysqli_query($con, $update_query)) {
            echo 'Information updated successfully.';
            // Update session data
            $_SESSION['user_info'] = [
                'id' => $id,
                'name' => $name,
                'education' => $education,
                'profession' => $profession
            ];
            // Redirect to verify.php
            header('Location: verify.php');
            exit();
        } else {
            echo 'Error updating record: ' . mysqli_error($con);
        }
    } else {
        // Insert new record
        $insert_query = "INSERT INTO form (Name, Education, Profession) VALUES ('$name', '$education', '$profession')";

        if (mysqli_query($con, $insert_query)) {
            $last_id = mysqli_insert_id($con); // Get last inserted ID
            echo 'Information saved successfully.';
            // Save user info in session
            $_SESSION['user_info'] = [
                'id' => $last_id, // Store ID for future reference
                'name' => $name,
                'education' => $education,
                'profession' => $profession
            ];
            // Redirect to verify.php
            header('Location: verify.php');
            exit();
        } else {
            echo 'Error saving record: ' . mysqli_error($con);
        }
    }
}

// Retrieve data for editing
$name = isset($_SESSION['user_info']['name']) ? $_SESSION['user_info']['name'] : '';
$education = isset($_SESSION['user_info']['education']) ? $_SESSION['user_info']['education'] : '';
$profession = isset($_SESSION['user_info']['profession']) ? $_SESSION['user_info']['profession'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information Form</title>
    <link rel="stylesheet" href="Login.css">
</head>
<body>
    <form action="info.php" method="POST" class="register">
        <h1>Information Form</h1>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

        <label for="education">Education:</label>
        <select id="education" name="education" required>
            <option value="" disabled <?php echo empty($education) ? 'selected' : ''; ?>>Select Education</option>
            <option value="Higher Education" <?php echo $education === 'Higher Education' ? 'selected' : ''; ?>>Higher Education</option>
            <option value="University" <?php echo $education === 'University' ? 'selected' : ''; ?>>University</option>
            <option value="Others" <?php echo $education === 'Others' ? 'selected' : ''; ?>>Others</option>
        </select>

        <label for="profession">Profession:</label>
        <select id="profession" name="profession" required>
            <option value="" disabled <?php echo empty($profession) ? 'selected' : ''; ?>>Select Profession</option>
            <option value="Teacher" <?php echo $profession === 'Teacher' ? 'selected' : ''; ?>>Teacher</option>
            <option value="Student" <?php echo $profession === 'Student' ? 'selected' : ''; ?>>Student</option>
            <option value="Freelancer" <?php echo $profession === 'Freelancer' ? 'selected' : ''; ?>>Freelancer</option>
            <option value="Businessman" <?php echo $profession === 'Businessman' ? 'selected' : ''; ?>>Businessman</option>
            <option value="Others" <?php echo $profession === 'Others' ? 'selected' : ''; ?>>Others</option>
        </select>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
