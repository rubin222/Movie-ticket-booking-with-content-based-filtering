<?php
session_start();
session_unset();  // Remove all session variables
session_destroy();  // Destroy the session
header('Location: homepage2.php');  // Redirect to homepage2
exit();
?>
