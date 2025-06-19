<?php
include 'config1.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM movies WHERE mid = $id");
    $movie = $result->fetch_assoc();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $showtimes = $_POST['showtimes'];
    $duration = $_POST['duration'];

    // Check if a new image is uploaded
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target = "uploads/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        $conn->query("UPDATE movies SET title='$title', genre='$genre', showtimes='$showtimes', duration='$duration', image='$image' WHERE mid=$id");
    } else {
        // Update without changing the image
        $conn->query("UPDATE movies SET title='$title', genre='$genre', showtimes='$showtimes', duration='$duration' WHERE mid=$id");
    }

    header("Location: adminpage.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Movie</title>
    <link rel="stylesheet" href="adminpage.css">
</head>
<body>
    <div class="container">
        <h2>Edit Movie</h2>
        <form action="edit_movie.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $movie['mid']; ?>">
            <input type="text" name="title" value="<?php echo $movie['title']; ?>" required>
            <input type="text" name="genre" value="<?php echo $movie['genre']; ?>" required>
            <input type="text" name="showtimes" value="<?php echo $movie['showtimes']; ?>" required>
            <input type="text" name="duration" value="<?php echo $movie['duration']; ?>" required>
            <label>Current Image:</label><br>
            <img src="uploads/<?php echo $movie['image']; ?>" width="100"><br>
            <input type="file" name="image">
            <button type="submit">Update Movie</button>
        </form>
    </div>
</body>
</html>
