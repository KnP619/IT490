<?php
if(isset($_GET["submit"]))
{
	session_start();
	$token = sha1($_SESSION['token']);
}
?>
<?php
//created = sha1($_SESSION['created']);  
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RpcClient {
	private $connection;
	private $channel;
	private $callback_queue;
	private $response;
	private $corr_id;
	//private $token;
	//private $created;
	public function __construct() {
		 
		$this->connection = new AMQPStreamConnection(
			'192.168.1.10', 5672, 'admin', 'knp33');

		$this->channel = $this->connection->channel();

		list($this->callback_queue, ,) = $this->channel->queue_declare(
			"", false, false, true, false);

		$this->channel->basic_consume(
			$this->callback_queue, '', false, false, false, false,
			array($this, 'on_response'));
	}

	public function tokenCheck() {
		if($this->$token == $_SESSION['token'])
			return true;
		else
			return false; 
	}

	public function on_response($rep) {
		if($rep->get('correlation_id') == $this->corr_id) {
			$this->response = $rep->body;
		}
	}

	


	public function callLogin($n,$n1) {
		$this->response = null;

		$this->corr_id = uniqid();

		$k=$n." ".$n1;	

		$UserName=$_GET["UserName"];
		$Password=$_GET["Password"];
		if(tokenCheck() == false){
			echo "login denied";
			exit; 
		}
		else {
			
		$Creds= Array("Username"=>$UserName,"Password"=>$Password);

		$JsonCreds=json_encode($Creds);	
		$msg = new AMQPMessage(
			(string)$JsonCreds ,
			array('correlation_id' => $this->corr_id,
			      'reply_to' => $this->callback_queue)
			);

		$this->channel->basic_publish($msg, '', 'rpc_queue');
		
		while(!$this->response) 
		{
			$this->channel->wait();
		}
		return ($this->response);
		}
	}
};
$Client_rpc = new RpcClient();

$response = $Client_rpc->callLogin($UserName,$Password);


//echo "<html><br> [.] Got ", $response, "<br><br></html>\n";
if ($response == 1){
//echo $_SERVER['REQUEST_URI'];
header("location:success.html");
}



?>


<html>

<body>

<form action="login_processor.php">
<fieldset><legend>Enter your information </legend>

<label for = "user"> User name </label>
	<input type=text name="UserName"
		 autofocus=on placeholder="User" autocomplete="off"><br><br>

<label for = "password"> User - Password</label>
	<input type=password name="Password" id="password"
		autofocus=on placeholder="Password" autocomplete="off" > &nbsp &nbsp
<input type =checkbox id="checkbox" onclick="See()">Show password<br><br>

<label for = "confirmpwd"> 
Confirm Password </label>
	<input type=password name="confirmpwd" id="confirmpwd"
		autofocus=on placeholder="confirmpwd" autocomplete="off"  onblur="check()"> <br>
<input type="hidden" name="token" value="<?php echo $token; ?>"> 
<input type=submit><br><br>
</fieldset>
</body>
</form>


</html>


