<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "user_auth";
define('GOOGLE_CLIENT_ID', '332507326181-r4e1dt61970lnqfbh0mv5pmer0s0i35r.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');
define('GOOGLE_REDIRECT_URI', 'http://localhost/auth_system/google-callback.php');


$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
