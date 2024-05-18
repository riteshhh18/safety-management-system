<?php
// Establish database connection
$servername = "localhost"; // Change this to your database server
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "user_authentication"; // Change this to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, check password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Start session and redirect to a logged-in page
            session_start();
            $_SESSION['email'] = $email;
            header("Location: index.html"); // Redirect to welcome page
            exit();
        } else {
            echo "Invalid password";
        }
    } else {
        echo "User not found";
    }
}

$conn->close();
?>
