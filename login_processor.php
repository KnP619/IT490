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

			return true;
		}
	else {
		echo "<html> UserName or Password is invalid </html>";
		return false;
	}
}
					  

}
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