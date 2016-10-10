<?php
//include("login.php");
$x = null;
if(isset($_POST["submit"])){
	session_start();
	$x = $_SESSION['user_token'];
	echo "XX";
}

// Login.php
if($_POST['UserName'] !== null && $_POST['Password'] !== null){
$UserName=$_POST["UserName"];
$Password=$_POST['Password'];
echo "<br> Username: $UserName . <br> Password: $Password";
$dbconn = mysqli_connect("localhost", "root", "knp33") or die(mysqli_error());
	echo" <br>connected <br>";
$db = mysqli_select_db($dbconn, "UserInfo");
$query = mysqli_query($dbconn, "select * from Login where UserName='$UserName' AND Password='$Password'");
$rows = mysqli_num_rows($query);
echo "<br>Rows: $rows <br>";
if ($rows == 1) {
	$_SESSION['user_token']=$UserName; // Initializing Session
	echo "rows"; 
	header("location: profile.php"); // Redirecting To Other Page
	
} else {
	$error = "UserName or Password is invalid";
	echo "invalid";
}
}
echo "$error";
 /*
if (isset($_SESSION['user_token'])){
	header("location:profile.php");
	}
	
<input type="hidden" name="user_token" value="<?php echo $user_token; ?>"> 

*/
?>
<html>

<body>

<form action="" method="POST">
<fieldset><legend>Enter your information </legend>

<label for = "user"> User name </label>
	<input type=text name="UserName"
		 autofocus=on placeholder="User" autocomplete="off"><br><br>

<label for = "password"> Password</label>
	<input type=password name="Password" id="password"
		autofocus=on placeholder="Password" autocomplete="off" > &nbsp &nbsp
<input type =checkbox id="checkbox" onclick="See()">Show password<br><br>

<input type=submit name="submit"><br><br>
</fieldset>

</form>


</html>
