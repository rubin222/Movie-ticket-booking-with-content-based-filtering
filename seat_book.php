<?php
$conn = new mysqli("localhost", "root", "", "user_auth");
$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data['seats'])) {
    foreach ($data['seats'] as $seat) {
        $conn->query("INSERT INTO bookings (seat_number) VALUES ('$seat')");
    }
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false]);
}
?>
