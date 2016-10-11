<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
class RpcClient {
	private $connection;
	private $channel;
	private $callback_queue;
	private $response;
	private $corr_id;

	public function __construct() {

		$this->connection = new AMQPStreamConnection(
			'192.168.1.14', 5672, 'admin', 'knp33');

		$this->channel = $this->connection->channel();

		list($this->callback_queue, ,) = $this->channel->queue_declare(
			"", false, false, true, false);

		$this->channel->basic_consume(
			$this->callback_queue, '', false, false, false, false,
			array($this, 'on_response'));
	}

	public function on_response($rep) {
		if($rep->get('correlation_id') == $this->corr_id) {
			$this->response = $rep->body;
		}
	}

public function call($n,$n1,$n2) {
		$this->response = null;

		$this->corr_id = uniqid();

		//$k=$n." ".$n1. " ". $n2 ." ". $n3 ;	
	//$user_check = "abcc";
	$UserName=$_GET["UserName"];
	$Password=$_GET["Password"];
	$submit = $_GET["submit"];
	$_SESSION["user_token"] = $UserName;
	$Creds= Array("Username"=>$UserName,"Password"=>$Password, "submit"=>$submit) ;


	$JsonCreds=json_encode($Creds);	
		$msg = new AMQPMessage(
			(string)$JsonCreds ,
			array('correlation_id' => $this->corr_id,
			      'reply_to' => $this->callback_queue)
			);

		$this->channel->basic_publish($msg, '', 'rpc_queue');

		while(!$this->response) {
			$this->channel->wait();
		}
		return ($this->response);
	}
};
$fibonacci_rpc = new RpcClient();

$response = $fibonacci_rpc->call($UserName,$Password, $submit);
//$response = $fibonacci_rpc->call($FirstName);
//$response = $fibonacci_rpc->call($LastName);
//$response = $fibonacci_rpc->call($Email);
//$response = $fibonacci_rpc->call($Password);

//echo "<html><br> [.] Got ", $response, "<br><br></html>\n";
if ($response == 1){
//echo $_SERVER['REQUEST_URI'];
	header("location:profile.php");
}
else {
	echo "<html><br> <b> error: Invalid credentials </b> </br></html>"; //add a redirection page
}
?>