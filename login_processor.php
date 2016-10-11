<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


$connection = new AMQPStreamConnection('localhost', 5672, 'admin', 'knp33');
$channel = $connection->channel();
$channel->queue_declare('rpc_queue', false, false, false, false);


function login($JsonCred) {
    $dbconn = new  mysqli("localhost","root","knp33");
		if ($dbconn->connect_error) {
		die("<html>Connection failed:".$dbconn->connect_error."</html>");
		}
	
	echo  $JsonCred;
	$db = mysqli_select_db($dbconn, "UserInfo");
	$json=json_decode($JsonCred,true);
	$UserName= $json["Username"];
	$Password=$json["Password"];
	//$submit=$json["submit"];


	if( $UserName !== null && $Password !== null){ 
		$query = mysqli_query($dbconn, "select * from Login where UserName='$UserName' AND Password='$Password'");
		$rows = mysqli_num_rows($query);
		echo "<br>Rows: $rows <br>";
		if ($rows == 1) //db returned true
		{ 
			//$_SESSION["user_token"] = $UserName;
			//$user_check= $_SESSION["user_token"];				
			//echo PHP_EOL. "UserCheck $: " . $_SESSION["user_token"];
			//header("Location: profile.php");
			return true;
		}
	else {
		echo "<html> UserName or Password is invalid </html>";
		return false;
	}
}
					  

					 
	

	/*if($_SESSION["user_token"] !== null){
		$user_check=$_SESSION["user_token"];
	//echo "User check: $user_check";
	}
	else{
	// SQL Query To Fetch Complete Information Of User
	$query=mysqli_query($dbconn, "select UserName from Login where UserName='$user_check'");
	$row = mysqli_fetch_assoc($query);
	echo"<br>" .PHP_EOL ."Row: $row";
	$login_session =$row['UserName'];
	echo "$login_session";

	if(!isset($login_session)){
	mysqli_close($dbconn); // Closing dbconn
	header('Location: loginform.php'); // Redirecting To Home Page
//echo "<br>$error";
	}
}*/



/**
if (is_array($JsonCred) || is_object($JsonCred))
{
    foreach ($JsonCred as $value)
    {
       echo "array value:\" $yarrr".PHP_EOL;
 
    }   
	return($JsonCred);
}
**/}
echo " [x] Awaiting RPC requests\n";
$callback = function($req) {
	$n = ($req->body);
	$credentials = json_decode($req->body);

//	echo " [.] recieved(",(string) fib($n), ")\n";
	$msg = new AMQPMessage(
		(string)login($n),
		array('correlation_id' => $req->get('correlation_id'))
		);	
 	//echo "(string)$n";
	$req->delivery_info['channel']->basic_publish(
		$msg, '', $req->get('reply_to'));
	$req->delivery_info['channel']->basic_ack(
		$req->delivery_info['delivery_tag']);
};
$channel->basic_qos(null, 1, null);
$channel->basic_consume('rpc_queue', '', false, false, false, false, $callback);
while(count($channel->callbacks)) {
    $channel->wait();
}
$channel->close();
$connection->close();
?>