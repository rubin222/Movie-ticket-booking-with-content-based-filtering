<?php
include 'config1.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $showtimes = $_POST['showtimes'];
    $duration = $_POST['duration'];
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    // Insert movie details into database
    $conn->query("INSERT INTO movies (title, genre, showtimes, duration, image) VALUES ('$title', '$genre', '$showtimes','$duration', '$image')");

    header("Location: adminpage.php");
}
?>
