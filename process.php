<?php
// Database connection
$servername = "localhost";
$username = "root"; // Default username for XAMPP
$password = ""; // Default password for XAMPP (empty by default)
$dbname = "safety_training";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$training_id = $_POST['training_id'];
$training_type = $_POST['training_type'];
$department = $_POST['department'];
$vendor_name = $_POST['vendor_name'];
$training_date_from = $_POST['training_date_from'];
$training_date_to = $_POST['training_date_to'];

// Insert data into the database
$sql = "INSERT INTO trainees (training_id, training_type, department, vendor_name, training_date_from, training_date_to)
        VALUES ('$training_id', '$training_type', '$department', '$vendor_name', '$training_date_from', '$training_date_to')";

if ($conn->query($sql) === TRUE) {
    // Query to retrieve data
    $query = "SELECT * FROM trainees WHERE training_date_from >= '$training_date_from' AND training_date_to <= '$training_date_to'";

    if (!empty($training_id)) {
        $query .= " AND training_id = '$training_id'";
    }
    if (!empty($training_type)) {
        $query .= " AND training_type = '$training_type'";
    }
    if (!empty($department)) {
        $query .= " AND department = '$department'";
    }
    if (!empty($vendor_name)) {
        $query .= " AND vendor_name = '$vendor_name'";
    }

    $result = $conn->query($query);

    $trainees = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $trainees[] = $row;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($trainees);
} else {
    echo json_encode(["error" => "Error: " . $sql . "<br>" . $conn->error]);
}

$conn->close();
?>
