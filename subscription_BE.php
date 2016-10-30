<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'admin', 'knp33');
$channel = $connection->channel();

$channel->queue_declare('user_fav', false, false, false, false);
function subscription($n) {
	
	$info=json_decode($n, true);
	//echo "Hello";
	 echo "info: $info[0]" . PHP_EOL;
     $UserName=$info[0];
	echo "info: $info[1]" . PHP_EOL;
  	$TeamName=$info[1];
	echo "info: $info[2]". PHP_EOL;
	$LeagueName= $info[2];
	$LeagueAcr = ""; 
	if($LeagueName == '1. Bundesliga 2016/17'){
		$LeagueAcr = 'B';
	}
	elseif($LeagueName == 'Serie A 2016/17'){
		$LeagueAcr = 'S';
	}
	elseif($LeagueName == 'Primera Division 2016/17'){
		$LeagueAcr = 'L';
	}
	elseif($LeagueName == 'Premier League 2016/17'){
		$LeagueAcr = 'P';
	}
	elseif($LeagueName == 'Ligue 1 2016/17'){
		$LeagueAcr = 'l';
	}
	$con =new  mysqli("localhost","root","knp33");
        if ($con->connect_error) {
        die("Connection failed:".$con->connect_error);
	}
	mysqli_select_db($con,"Soccer");
	$sql= "INSERT INTO `Subscription` (`UserName`, `TeamName`, `LeagueName`, `LeagueAcr`) VALUES ('$UserName','$TeamName', '$LeagueName', '$LeagueAcr')";

     if(mysqli_query($con,$sql)){

             echo "<br><br>New record created successfully <br><br>" .PHP_EOL;
		     return "Subscribed";
                                      }

     else {

            echo "Error: ".$sql."<br>".mysqli_error($con) . PHP_EOL;
		    error_log("Something went wrong with subscribing". mysqli_error($con),3, "/var/log/php_erros.log");
		  	return "Oops Something's wrong";
}
//$result=mysqli_query($con,$sql) or die("Error: ".mysqli_error($connection) . error_log("Failed to add user fav", 3, "/var/log/php_error.log"));


}



echo " [x] Awaiting RPC requests\n" . PHP_EOL;
$callback = function($req) {
    $n = ($req->body);
    echo " [.] fib(", $n, ")\n"; 

    $msg = new AMQPMessage(
        (string)subscription($n),
        array('correlation_id' => $req->get('correlation_id'))
        );

    $req->delivery_info['channel']->basic_publish(
        $msg, '', $req->get('reply_to'));
    $req->delivery_info['channel']->basic_ack(
        $req->delivery_info['delivery_tag']);


};

$channel->basic_qos(null, 1, null);
$channel->basic_consume('user_fav', '', false, false, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();
?>