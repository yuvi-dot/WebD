<?php
session_start();

// Database credentials
$localhost = "localhost";
$db_User = "root"; // Renamed for clarity
$db_Password = "";
$db_Name = "codegenius";

// Create connection
$con = mysqli_connect($localhost, $db_User, $db_Password, $db_Name);

// Check connection
if (!$con) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . mysqli_connect_error()]));
}

// Check if POST data exists
if (isset($_POST['Name']) && isset($_POST['Password'])) {
    // Get POST data safely
    $Name = mysqli_real_escape_string($con, $_POST['Name']);
    $Password = mysqli_real_escape_string($con, $_POST['Password']);
    $remember_me = isset($_POST['remember_me']); // Check if "Remember me" is checked

    // Check if Name and Password are not empty
    if (!empty($Name) && !empty($Password)) {
        // Prepare statement to find the user
        $stmt = $con->prepare("SELECT * FROM login WHERE Name = ?");
        $stmt->bind_param("s", $Name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User exists, fetch data
            $row = $result->fetch_assoc();

            // Check if the Password is correct
            if (password_verify($Password, $row['Password'])) {
                // Password is correct, start session
                session_regenerate_id(true);
                $_SESSION['Name'] = $Name;

                // Set cookies if "Remember me" is checked
                if ($remember_me) {
                    setcookie('Name', $Name, time() + (86400 * 30), "/"); // 30 days
                }

                // Redirect to index.html
                echo json_encode(["status" => "success", "redirect" => "index.html"]);
                exit();
            } else {
                // Incorrect Password, send error message
                echo json_encode(["status" => "error", "message" => "Incorrect Password."]);
                exit();
            }
        } else {
            // User does not exist, register the user
            $hashed_Password = password_hash($Password, PASSWORD_DEFAULT); // Use PASSWORD_DEFAULT here
            
            // Prepare the insert statement for login
            $stmt = $con->prepare("INSERT INTO login (Name, Password) VALUES (?, ?)");
            $stmt->bind_param("ss", $Name, $hashed_Password);
            
            if ($stmt->execute()) {
                // Registration successful, start session
                session_regenerate_id(true);
                $_SESSION['Name'] = $Name; // Start session for the new user

                // Insert into info table
                $stmt = $con->prepare("INSERT INTO info (Name) VALUES (?)"); // Assuming you only need the name for now
                $stmt->bind_param("s", $Name);
                $stmt->execute();

                // Redirect to info.php
                header('Location: info.php'); // Redirect to info.php after successful registration
                exit();
            } else {
                // Registration failed
                echo json_encode(["status" => "error", "message" => "Registration failed. Please try again."]);
                exit();
            }
        }
    } else {
        // Missing Name or Password
        echo json_encode(["status" => "error", "message" => "Please enter both Name and Password."]);
        exit();
    }
} else {
    // Show error if form data is missing
    echo json_encode(["status" => "error", "message" => "Form data is missing. Please try again."]);
    exit();
}

// Close the connection
mysqli_close($con);
?>
