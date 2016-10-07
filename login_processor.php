<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'admin', 'knp33');
$channel = $connection->channel();
$channel->queue_declare('rpc_queue', false, false, false, false);

function dbConnect(){
	global $dbh; 
	$dbh = mysqli_connect("localhost", "root", "knp33", "UserInfo") or die(mysqli_error());
	}
function login($JsonCred) {
	dbConnect(); 
	$json=json_decode($JsonCred,true);
	$username= $json["Username"];
	$password=$json["Password"];

	$s="select * from RegistrationPage  WHERE UserName='$UserName' or Email='$Email' "; 
	$t= mysqli_query($dbh,$s);
	$count = mysqli_num_rows($t);
	if($count > 0) {
		header("location:success.html");
	}
	else
	{
		echo "Invalid user";
		exit;
	}	
}



if (is_array($JsonCred) || is_object($JsonCred))
{
    foreach ($JsonCred as $value)
    {
       echo "array value:\" $yarrr".PHP_EOL;
 
    }   
	return($JsonCred);
}
echo " [x] Awaiting RPC requests\n";
$callback = function($req) {
	$n = ($req->body);
	$credentials = json_decode($req->body);

//	echo " [.] recieved(",(string) fib($n), ")\n";
	$msg = new AMQPMessage(
		(string)fib($n),
		array('correlation_id' => $req->get('correlation_id'))
		);	

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
