<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_auth";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Database connection failed!"]));
}

$data = json_decode(file_get_contents("php://input"), true);
$seats = $data['seats'];

if (!empty($seats)) {
    foreach ($seats as $seat) {
        $conn->query("UPDATE seats SET status='booked' WHERE seat_number='$seat'");
    }
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "No seats selected!"]);
}
?>
