<?php
include 'config.php';
session_start(); // To access OTP from session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = $_POST['otp'];

    // Check if the entered OTP matches the stored one
    if ($entered_otp == $_SESSION['otp']) {
        $email = $_SESSION['email']; // Retrieve email from session
        $new_password = password_hash("default123", PASSWORD_BCRYPT); // Default password

        // Update the password in the database
        $sql = "UPDATE users SET password='$new_password' WHERE email='$email'";

        if (mysqli_query($conn, $sql)) {
            echo "Password reset successfully. Your new password is: default123 (Please change it after logging in)";
            unset($_SESSION['otp']); // Clear OTP from session
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Invalid OTP. Please try again.";
    }
}
?>

<!-- HTML Form for OTP verification -->
<form method="POST" action="verify_otp.php">
    Enter OTP: <input type="text" name="otp" required>
    <button type="submit">Verify OTP</button>
</form>
