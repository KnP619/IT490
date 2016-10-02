<?php
include ("account.php") ;

( $dbh = mysqli_connect ( "$hostname", "$user", "$pass", "Registration" ) )
	        or    die ( mysqli_error());
print "<br>Connected to MySQL<br>";

////////////Fetch input
$UserName = $_GET["UserName"];
$Email = $_GET["Email"];
$Password =$_GET["Password"];
$FirstName = $_GET["FirstName"];
$LastName = $_GET["LastName"];

//////////Registered?




$s="select * from RegistrationPage  WHERE UserName='$UserName' or Email='$Email' "; 
$t= mysqli_query($dbh,$s);
$count = mysqli_num_rows($t);
echo " $count";





print( $UserName. '<br>'. $Password. '<br>'. $FirstName. '<br>'. $LastName. '<br>'. $Email. '<br>' . $count. '<br>');
////////////Insert

//$count = REGnum($UserName, $Email);

if($count>0){
	echo htmlspecialchars("$UserName.'or'.$Email.'already exists please enter a new user AND a unique email'");

}

else{
	$s = "INSERT INTO RegistrationPage VALUES ('$UserName','$FirstName','$LastName','$Email',sha1('$Password'))"; 
	mysqli_query($dbh,$s) or die (mysqli_error($dbh));

}


?>
