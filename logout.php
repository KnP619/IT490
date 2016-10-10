<?php
//unset($_SESSION["user_token"];
session_destroy(); // Destroying All Sessions
echo "logging out";
//sleep(5); 
header("Location: loginform.php"); // Redirecting To Home Page
?>
