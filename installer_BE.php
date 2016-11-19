<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'admin', 'knp33');
$channel = $connection->channel();

$channel->queue_declare('bundle_install', false, false, false, false);

function installer($NameOfTask) {
///installer code
	$dbconn = new  mysqli("127.0.0.1","root","knp33","Versions");
	if ($dbconn->connect_error) {
		die("Connection failed:".$dbconn->connect_error);
		}
	else {
		echo "Connected to mysql".PHP_EOL;
	}
	$s = "SELECT * FROM `AllTasks` WHERE Taskname = '$NameOfTask'";
	$result = mysqli_query($dbconn, $s) or die(mysqli_error($dbconn));
	$row = mysqli_fetch_assoc($result);
	$NameOfTargZ = $row['tarname'];
	$version = $row['CurrentVersion'];
	$returnbool = false;
	$decompress = new PharData("$NameOfTargZ");
	$decompress->decompress();
	unlink("$NameOfTargZ");
	$str = substr($NameOfTargZ, 0, -3);	
	$arch = new PharData("$str");
	mkdir('update',0777,true);
	$arch->extractTo(__DIR__.'/update/',null,true);
	//$file = fopen(__DIR__.'/update/bundle.ini', "r") or die("Unable to open file!");
	$parse = parse_ini_file(__DIR__."/update/bundle.ini", true);
	//$check = 0;
	foreach($parse as $arr){
		if($arr["Name"] != $NameOfTask){
			continue;
		}
		foreach($arr as $dest){
			$key = array_search($dest, $arr);
			if($key == "Name"){
				continue;
			}
			else
			{
			if(!file_exists($dest)){
				try{
					mkdir(dirname($dest),0777,true);
				}
				catch (Exception $e) {
   					 echo 'Caught exception: '. $e->getMessage() .PHP_EOL;
					}

				//$check++;
			}
			//$cpp = "cp -p " .__DIR__."/update/$key " . $dest;
			//echo $cpp;
			if(copy(__DIR__.'/update/'.$key, $dest)){
				$returnbool = true;
				echo "copied to $dest" . PHP_EOL;
				unlink(__DIR__.'/update/'.$key);
			}
			else{
				//return false;
				//die("Copy failed".PHP_EOL);
			}
		} 
	}
	}
	unlink(__DIR__.'/update/bundle.ini');
	exec("rmdir update");
	//unlink("$NameOfTargZ");
	unlink($str);
	if($returnbool == true){
		$user = get_current_user(); 
		$datetime = date('Y-m-d H:i:s');
		$sql = "INSERT INTO `InstallHistory`(`User`, `TaskInstall`, `TaskVersion`, `DateTime`) VALUES ('$user', '$NameOfTask','$version','$datetime')";
		if(!mysqli_query($dbconn,$sql)){
					return false;
					die("Update to DB failed". PHP_EOL);
				}
	}
	return $returnbool;
}

function rollback($NameOfTask){
	$dbconn = new  mysqli("127.0.0.1","root","knp33","Versions");
	if ($dbconn->connect_error) {
		die("Connection failed:".$dbconn->connect_error);
		}
	else {
		echo "Connected to mysql".PHP_EOL;
	}
	$user = get_current_user();
	$s = "SELECT * FROM `InstallHistory` WHERE USER = '$user' AND TaskInstall = '$NameOfTask' ORDER BY id DESC LIMIT 1 OFFSET 1";
	$result = mysqli_query($dbconn, $s) or die("EROR WHILE CHECKING: $s" . PHP_EOL);
	$row = mysqli_fetch_assoc($result);
	$rollback_ver = $row['TaskVersion'];
	$rollback_tar = $NameOfTask . $rollback_ver. ".tar.gz";
	
}
echo " [x] Awaiting RPC requests\n";
$callback = function($req) {
    $n1 = ($req->body);
	$n=json_decode($n1,true);

	var_dump($n);
	/**$Param;
	
	if($n[0] == 'install_bundle'){
		
	$Param=installer($n[1]);	
		
	}**/
	//if($n[0] == 'install_bundle')
		$msg = new AMQPMessage(
			(string)$n[0]($n[1],$n[2]),
			array('correlation_id' => $req->get('correlation_id'))
			);

		$req->delivery_info['channel']->basic_publish(
			$msg, '', $req->get('reply_to'));
		$req->delivery_info['channel']->basic_ack(
			$req->delivery_info['delivery_tag']);
	
};

$channel->basic_qos(null, 1, null);
$channel->basic_consume('bundle_install', '', false, false, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();

?>
