

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Booking</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="homepage2.css">
</head>
<body>
<div class="main-content">
    <header>
        <div class="logo">
            <img src="image/logo2.jpg" class="pic"> 
            <span class="part1">Anyday</span><span class="part2"> Movie</span>
        </div>
        <ul class="nav">
            <li><a href="homepage2.php">Home</a></li>
            <li><a href="mytickets.php">My Tickets</a></li>
            <li><a href="recommendation.php">Recommendations</a></li>
            <li><a href="#contact">Contact</a></li>
            <li>
                <i class="fa fa-user-circle user-icon" aria-hidden="true" onclick="window.location.href='index.php';" style="cursor: pointer;"></i>
                
            </li>
            
        </ul>
    </header>
    
    <section class="hero">
        <h1>Welcome to Anyday Movie</h1>
        <p>Book your favorite movie tickets online and get personalized recommendations!</p>
        <button class="btn" onclick="window.location.href='';">&#127915; Buy Tickets</button>
    </section>

    <section id="contact">
        <h2>Contact Us</h2>
        <p>Have questions? Get in touch with us via any of the following ways!</p>

        <!-- Contact Info Section -->
        <div class="contact-info">
            <div><i class="fa fa-phone-alt"></i><p>+1 234 567 890</p></div>
            <div><i class="fa fa-envelope"></i><p>support@anydaymovie.com</p></div>
            <div><i class="fa fa-map-marker-alt"></i><p>123 Movie St, Hollywood, CA</p></div>
        </div>

        <!-- Social Media Links -->
        <div class="social-links">
            <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook"></i></a>
            <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="mailto:support@anydaymovie.com" target="_blank"><i class="fa fa-envelope"></i></a>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 Anyday Movie. All Rights Reserved.</p>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector('a[href="#contact"]').addEventListener("click", function (event) {
                event.preventDefault();
                document.querySelector("#contact").scrollIntoView({ behavior: "smooth" });
            });
        });
    </script>
</body>
</html>
