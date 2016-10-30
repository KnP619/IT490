<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'admin', 'knp33');
$channel = $connection->channel();
$channel->queue_declare('rpc_queueR', false, false, false, false);

function register($JsonCred) {

//echo "/n/n".(string)$JsonCred."/n/n";
	$logger = new Logger('login_logger');

	// Register the logger to handle PHP errors and exceptions
	ErrorHandler::register($logger);

	// Add log file handler
	$logger->pushHandler(new StreamHandler('/var/log/php_errors.log', Logger::ERROR));

	// Add the papertrail handler
	$logger->pushHandler(new SyslogUdpHandler("logs4.papertrailapp.com", 28975, LOG_USER));


	$json=json_decode($JsonCred,true);

	echo $json["Username"];
	$username= $json["Username"];
	$password=$json["Password"];
	$FirstName=$json["FirstName"];
	$LastName=$json["LastName"];
	$Email=$json["Email"];

	$con =new  mysqli("localhost","root","knp33");

		if ($con->connect_error) {
		$logger->addError("mysql connect error $con->connect_error \n");
		die("<html>Connection failed:".$con->connect_error."</html>");

	}

	mysqli_select_db($con,"UserLogin");


	$id;

	$sql = "INSERT INTO RegistrationPage VALUES('$username','$FirstName','$LastName','$Email','$password');";


		if(mysqli_query($con,$sql)){
			$id=mysqli_insert_id();	
			return 1;
	}
		else {
			$logger->addError("$sql: " .mysqli_error($con)." \n");
			return "<html>Error: ".$sql."<br>".mysqli_error($con)."</html>";
	}

	//echo $n;


	if (is_array($JsonCred) || is_object($JsonCred))
	{
		foreach ($JsonCred as $value)
		{
		   echo "array value:\" $yarrr".PHP_EOL;

		}
		}

		return($JsonCred);
}
echo " [x] Awaiting RPC requests\n";
$callback = function($req) {
	$n = ($req->body);
//	$credentials = json_decode($req->body);

//        echo " [.] recieved(",(string) register($n), ")\n";
	$msg = new AMQPMessage(
		(string)register($n),
		array('correlation_id' => $req->get('correlation_id'))
		);	

	$req->delivery_info['channel']->basic_publish(
		$msg, '', $req->get('reply_to'));
	$req->delivery_info['channel']->basic_ack(
		$req->delivery_info['delivery_tag']);
};
$channel->basic_qos(null, 1, null);
$channel->basic_consume('rpc_queueR', '', false, false, false, false, $callback);
while(count($channel->callbacks)) {
    $channel->wait();
}
$channel->close();
$connection->close();
?>

