<?php
session_start();// Starting Session

$dbconn = mysqli_connect("localhost", "root", "knp33") or die(mysqli_error());
	echo" <br>connected <br>";
$db = mysqli_select_db($dbconn, "UserInfo");

$user_check = "";
// Storing Session
if($_SESSION["user_token"] !== null){
$user_check=$_SESSION["user_token"];
//echo "User check: $user_check";
} 
// SQL Query To Fetch Complete Information Of User
$query=mysqli_query($dbconn, "select UserName from Login where UserName='$user_check'");
$row = mysqli_fetch_assoc($query);
echo"<br>" .PHP_EOL ."Row: $row";
$login_session =$row['UserName'];
echo "$login_session";

if(!isset($login_session)){
	mysqli_close($dbconn); // Closing dbconn
	header('Location: loginform.php'); // Redirecting To Home Page
}
?>