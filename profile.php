<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: homepage.php"); // Redirect if not logged in
    exit();
}
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="profile.css">  
</head>
<body>
    <div class="profile-container">
        <h1 class="username-text">Hi, <?php echo htmlspecialchars($username); ?>!</h1>
        <button class="logout-btn" onclick="window.location.href='logout.php';">Logout</button>
    </div>
</body>
</html>


<style>

body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background: linear-gradient(135deg, #ff9a9e, #fad0c4); /* Cute gradient */
    font-family: 'Poppins', sans-serif;
    margin: 0;
}

.profile-container {
    text-align: center;
    background: white;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
    width: 50%;
    max-width: 400px;
}

.username-text {
    font-size: 2.5rem;
    font-weight: bold;
    color: #ff6f61; /* Cute pinkish color */
    margin-bottom: 20px;
}

.logout-btn {
    padding: 12px 25px;
    font-size: 18px;
    font-weight: bold;
    border: none;
    border-radius: 8px;
    background-color: #ff4757; /* Red logout button */
    color: white;
    cursor: pointer;
    transition: 0.3s;
}

.logout-btn:hover {
    background-color: #e84118; /* Darker red */
}

</style>