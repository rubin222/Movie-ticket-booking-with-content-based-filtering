<?php
$conn = new mysqli("localhost", "root", "", "user_auth");

$data = json_decode(file_get_contents("php://input"), true);
$token = $data['payment']['token'];
$movie_id = $data['movie_id'];
$showtime = $data['showtime'];

$headers = ["Authorization: Key YOUR_KHALTI_SECRET_KEY"];

$ch = curl_init("https://khalti.com/api/v2/payment/verify/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(["token" => $token]));

$response = curl_exec($ch);
curl_close($ch);
$responseData = json_decode($response, true);

if (isset($responseData['amount']) && $responseData['state']['name'] === "Completed") {
    foreach ($data['seats'] as $seat) {
        $stmt = $conn->prepare("INSERT INTO bookings (seat_number, movie_id, showtime) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $seat, $movie_id, $showtime);
        $stmt->execute();
    }
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false]);
}
?>
