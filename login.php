<?php
$host = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "user_management";

// Create connection
$conn = new mysqli($host, $dbUser, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute SQL query
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Redirect to the tax calculation page after successful login
            header("Location:index_1.php");
            exit(); // Stop further script execution
        } else {
            echo "<h1>Invalid password. Please try again.</h1>";
        }
    } else {
        echo "<h1>Username does not exist.</h1>";
    }

    $stmt->close();
}

$conn->close();
?>