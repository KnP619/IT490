<?php
    $dbconn = new  mysqli("10.200.44.208","ket","knp33","Soccer");
        if ($dbconn->connect_error) {
        die("<html>Connection failed:".$dbconn->connect_error."</html> \n");
        }   
        else{
            //echo "Connected \n";
        }
$time_stamp = date("Y-m-d", time());
 
echo "$time_stamp \n";
//$time_stamp = '2016-08-27';
//echo substr("2016-08-26T18:30:00Z", 0, -10) . PHP_EOL;
 
$s = "SELECT * FROM B WHERE GameDate LIKE '$time_stamp%'
UNION
SELECT * FROM l WHERE GameDate LIKE '$time_stamp%'
UNION
SELECT * FROM L WHERE GameDate LIKE '$time_stamp%'
UNION
SELECT * FROM P WHERE GameDate LIKE '$time_stamp%'
UNION
SELECT * FROM S WHERE GameDate LIKE '$time_stamp%'";
$result = mysqli_query($dbconn,$s) or die($dbconn->connect_error);
$teams = array();
while($row = mysqli_fetch_assoc($result)){
    $away = $row['awayTeamName'];
    $home = $row['homeTeamName'];
	echo "Home: $home VS Away: $away \n";
    if (!in_array("$home", $teams))
    {
        array_push($teams,$home);
    }
    if(!in_array("$away",$teams)){
        array_push($teams,$away);
    }
}
print_r($teams);
$usr=Array();
foreach($teams as $teamname){
    echo "Current team: $teamname \n";
    $sql ="SELECT * FROM `Subscription` WHERE TeamName ='$teamname'";
    mysqli_select_db($dbconn,'Soccer');
    $result = mysqli_query($dbconn,$sql) or die ("Error in team search");
	while($subrow = mysqli_fetch_assoc($result)){
		var_dump($subrow);
		$usr = $subrow['UserName'];
		//var_dump($usr) ;
		if( $usr != NULL){
			//echo $usr . "\n";
			mysqli_select_db($dbconn,'UserInfo');
			$u = "SELECT * FROM `RegistrationPage` WHERE `UserName` = '$usr'";
			$res = mysqli_query($dbconn,$u) or die("FAILED getting email \n");
			$rrow = mysqli_fetch_assoc($res);
			$email = $rrow['Email'];
			$from = "it490brogrammers@gmail.com";//p: 490asdfasdf
			$Subject = "Team Notification";
			$message = "The team that you are following: $teamname is going to play today!";
			$Emailbody = $subrow['UserName'];
			mail($email, $Subject, $message, $Emailbody, "-f$from");
		echo "emailing to $email \n";
    }
	}
}
