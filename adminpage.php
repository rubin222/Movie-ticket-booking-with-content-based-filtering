<?php
session_start();
include 'config1.php';  // Include the database connection

// Handle movie deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM movies WHERE mid=$id");
    header("Location: adminpage.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Movie Booking</title>
    <link rel="stylesheet" href="adminpage.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="image/logo2.jpg" class="pic"> 
            <span class="part1">Anyday</span><span class="part2"> Movie</span>
        </div>
        <h1 class="admin-title">Admin Panel</h1>
    </header>

    <div class="container">
        <!-- Upload Movie Form -->
        <h2>Upload Movie</h2>
        <form action="upload_movie.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Movie Name" required>
            <input type="text" name="genre" placeholder="Genre" required>
            <input type="text" name="showtimes" placeholder="Showtimes (comma separated)" required>
            <input type="text" name="duration" placeholder="Total Duration (time in hr and min)" required>
            <input type="file" name="image" required>
            <button type="submit">Upload Movie</button>
        </form>
    </div>

    <div class="container1">
        <!-- Manage Movies Table -->
        <h2>Manage Movies</h2>
        <table>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Genre</th>
                <th>Showtimes</th>
                <th>Duration</th>
                <th>Actions</th>
            </tr>

            <?php
            $movies = $conn->query("SELECT * FROM movies");
            while ($row = $movies->fetch_assoc()) {
                echo "
                <tr>
                    <td><img src='uploads/{$row['image']}' alt='{$row['title']}' width='100'></td>
                    <td class='movie-title'>{$row['title']}</td>
                    <td class='movie-genre'>{$row['genre']}</td>
                    <td>";
                
                $showtimes = explode(",", $row['showtimes']);
                foreach ($showtimes as $time) {
                    echo "<button class='showtime-btn'>{$time}</button>";
                }
                
                echo "</td>
                    <td class='movie-duration'>{$row['duration']}</td>
                    <td class='action-buttons'>
                        <a href='edit_movie.php?id={$row['mid']}' class='update-btn'>Update</a>
                        <a href='?delete={$row['mid']}' onclick='return confirm(\"Are you sure?\")' class='delete-btn'>Delete</a>
                    </td>
                </tr>";
            }
            ?>
        </table>
    </div>

</body>
</html>