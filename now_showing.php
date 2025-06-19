<?php
include 'config1.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Now Showing - Anyday Movie</title>
    <link rel="stylesheet" href="now_showing.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="image/logo2.jpg" class="pic"> 
            <span class="part1">Anyday</span><span class="part2"> Movie</span>
        </div>
        <ul class="nav">
            <li><a href="homepage.php">Home</a></li>
            <li><a href="mytickets.php">My Tickets</a></li>
            <li><a href="recommendation.php">Recommendations</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </header>

    <h1>Now Showing</h1>
    
    <div class="date-selector">
        <?php 
        for ($i = 0; $i < 10; $i++) {
            $date = date('j M', strtotime("+$i day"));
            $is_today = (date('j M') == $date) ? 'today' : '';
            echo "<button class='date-btn $is_today'>$date</button>";
        }
        ?>
    </div>
    <div class="movie-container">
    <?php
    $movies = $conn->query("SELECT mid, title, duration, genre, image, showtimes FROM movies");
    while ($row = $movies->fetch_assoc()) {
        if (!isset($row['mid'])) {
            continue; // Skip this row if 'mid' is missing
        }

        echo "
        <div class='movie-card'>
            <img src='uploads/{$row['image']}' alt='{$row['title']}'>
            <h2>{$row['title']}</h2>
            <p> {$row['duration']}</p>
            <p> {$row['genre']}</p>
            <div class='showtimes'>";

        $showtimes = explode(",", $row['showtimes']);
        foreach ($showtimes as $time) {
            echo "<a href='hall.php?mid=" . urlencode($row['mid']) . "&showtime=" . urlencode($time) . "'>
                    <button class='showtime-btn'>$time</button>
                  </a>";
        }

        echo "</div></div>";
    }
    ?>
</div>

    

    <script>
        function redirectToHall(mid, time) {
            window.location.href = "hall.php?mid=" + mid + "&time=" + encodeURIComponent(time);
        }
    </script>
</body>
</html>
