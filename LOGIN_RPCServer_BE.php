<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


$connection = new AMQPStreamConnection('localhost', 5672, 'admin', 'knp33');
$channel = $connection->channel();
$channel->queue_declare('rpc_queueL', false, false, false, false);

$error = "";
function login($JsonCred) {
    $dbconn = new  mysqli("localhost","root","knp33");
		if ($dbconn->connect_error) {
		die("<html>Connection failed:".$dbconn->connect_error."</html>");
		}
	
	echo  $JsonCred . PHP_EOL;
	$db = mysqli_select_db($dbconn, "UserInfo");
	$json=json_decode($JsonCred,true);
	$UserName= $json["Username"];
	//echo "$UserName";
	
	$Password=$json["Password"];
	//echo "$Password";
	//$submit=$json["submit"];


	if( $UserName !== null && $Password !== null){ 
		$query = mysqli_query($dbconn, "select * from RegistrationPage  where UserName='$UserName' AND Password='$Password'") or die("error: ". mysqli_error($dbconn));
		
		
		
		$rows = mysqli_num_rows($query);
		echo "<br>Rows: $rows <br>";
		if ($rows == 1) //db returned true
		{
			echo "Login successful for $UserName" . PHP_EOL;
			return true;
		}
	else {
		$error = "UserName or Password is invalid";
		$time_stamp = date("d F Y H:i:s", time());
		error_log("$time_stamp: $error \n", 3, "/var/log/php_errors.log");
		echo " $time_stamp" . "--". "$error". PHP_EOL;
		return "Invalid Password";
		;
	}
}
					  

}
echo " [x] Awaiting RPC requests\n". PHP_EOL;
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
$channel->basic_consume('rpc_queueL', '', false, false, false, false, $callback);
while(count($channel->callbacks)) {
    $channel->wait();
}
$channel->close();
$connection->close();
?>
