<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "integrative1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data['name']) && !empty($data['email']) && !empty($data['age']) && !empty($data['gender']) && !empty($data['phoneNumber'])) {
    $name = $conn->real_escape_string($data['name']);
    $email = $conn->real_escape_string($data['email']);
    $age = $conn->real_escape_string($data['age']);
    $gender = $conn->real_escape_string($data['gender']);
    $phoneNumber = $conn->real_escape_string($data['phoneNumber']);

    $sql = "INSERT INTO clients (name, email, age, gender, phoneNumber) VALUES ('$name', '$email', '$age', '$gender', '$phoneNumber')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Client data added successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $sql . "<br>" . $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid input."]);
}

$conn->close();
?>
