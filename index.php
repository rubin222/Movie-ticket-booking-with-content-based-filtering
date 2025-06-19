<?php
session_start();
$isLoggedIn = isset($_SESSION['email']); // Check if the user is logged in
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Signup</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://accounts.google.com/gsi/client" async defer></script>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <img src="image/logo2.jpg" class="pic"> 
                <span class="part1">Anyday</span><span class="part2"> Movie</span>
            </div>
            
            <!-- Close (X) Button -->
            <a href="homepage2.php" class="close-btn">&times;</a>
        </header>

        <div class="form-box">
            <?php if (!$isLoggedIn): ?>
                <div class="button-box">
                    <button id="signInBtn" onclick="showSignIn()">Sign In</button>
                    <button id="signUpBtn" onclick="showSignUp()">Sign Up</button>
                </div>
                
                <!-- Sign In Form -->
                <form id="signInForm" action="signin.php" method="POST" autocomplete="off">
                    <input type="text" name="email" placeholder="Email/Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    
                    <div class="form-action">
                        <button type="submit">Sign In</button>
                        <a href="forgot_password.php">Forgot Password?</a>
                    </div>

                    <div class="googleSignIn" id="googleSignIn"></div>
                </form>

                <!-- Sign Up Form -->
                <form id="signUpForm" action="signup.php" method="POST" style="display:none;">
                    <input type="text" name="first_name" placeholder="First Name" required>
                    <input type="text" name="last_name" placeholder="Last Name" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="text" name="mobile" placeholder="Mobile" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                    <button type="submit">Sign Up</button>
                </form>

            <?php else: ?>
               
                <div class="logged-in-box">
                    <p>Welcome, <?php echo htmlspecialchars($_SESSION['email']); ?>!</p>
                    <form action="logout.php" method="POST">
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
