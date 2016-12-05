<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'admin', 'asdfasdf');
$channel = $connection->channel();

$channel->queue_declare('deploy', false, false, false, false);

function deployBundle($ip,$username, $taskname){
	echo "deployFunc".PHP_EOL;
	//shell_exec("php build_bundle.php tasks.ini $taskname");
	$dbconn = new  mysqli("localhost","root","asdfasdf","Versions");
	if ($dbconn->connect_error) {
		echo "DB".PHP_EOL;
		die("Connection failed:".$dbconn->connect_error);
		}
	else {
		echo "Connected to mysql".PHP_EOL;
	}
	$s = "SELECT `Taskname`, `tarname`, `CurrentVersion`, `timestamp` FROM `AllTasks` WHERE TaskName = '$taskname'";
	$result = mysqli_query($dbconn, $s) or die("EROR WHILE CHECKING");
	$row = mysqli_fetch_assoc($result);
	$filename = $row['tarname'];
	echo "$filename" .PHP_EOL;
	if(file_exists("/home/prit/Downloads/Packages/$filename")){
		echo "scp /home/prit/Downloads/Packages/$filename $username@$ip:/home/$username/Downloads/Packages".PHP_EOL;
		shell_exec("scp /home/prit/Downloads/Packages/$filename $username@$ip:/home/$username/Downloads/Packages");
		echo 'done';}
	else {echo "failed update dir";
		 return false;}
	//ssh2_scp_send($connection, __DIR__.'/RPC_Backend.tar', '/home/RPC_Backend.tar',0777);

	echo "Done...".PHP_EOL;

	return true;
}
echo " [x] Awaiting RPC requests\n";
$callback = function($req) {

    $n1 = ($req->body);
$n=json_decode($n1,true);

	var_dump($n);

$Param;

   if ($n[0] == 'deploy_bundle'){
echo  "$Param fuck2".PHP_EOL;
	$Param=deployBundle($n[1],$n[2],$n[3]);
} 


    $msg = new AMQPMessage(
        (string) $Param,
        array('correlation_id' => $req->get('correlation_id'))
        );

    $req->delivery_info['channel']->basic_publish(
        $msg, '', $req->get('reply_to'));
    $req->delivery_info['channel']->basic_ack(
        $req->delivery_info['delivery_tag']);
};

$channel->basic_qos(null, 1, null);
$channel->basic_consume('deploy', '', false, false, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();
?>
