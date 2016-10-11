
<?php
//unset($_SESSION["user_token"];
session_destroy(); // Destroying All Sessions
echo "logging out";
//sleep(5); 
header("Location: loginP.php"); // Redirecting To Home Page
?>

