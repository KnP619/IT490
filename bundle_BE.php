<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'admin', 'knp33');
$channel = $connection->channel();

$channel->queue_declare('bundle', false, false, false, false);

function buildBundle($PathToini,$NameOfTask) {

	//$file = fopen("$PathToini", "r") or die("Unable to open file!");
	//$tarname = $NameOfTar.'.tar'; //should be nameoftar+task
	//$archive = new PharData($tarname);
	//$archive->addFile('text.txt');
	$parse = parse_ini_file("$PathToini",true);
	mkdir('update',0777,true);
	$dbconn = new  mysqli("10.200.44.140","ket","knp33","Versions");
	if ($dbconn->connect_error) {
		die("Connection failed:".$dbconn->connect_error);
		}
	else {
		echo "Connected to mysql".PHP_EOL;
	}
	$hit = 0;
	foreach($parse as $arr){
		//print_r($arr['Name']);
	if($arr["Name"]== $NameOfTask){
		if($arr["Name"]){
			$tablename = $arr["Name"];
			echo "Table: $tablename" . PHP_EOL;
		}
		foreach($arr as $source){
			$key = array_search($source, $arr);/*
			if($key = "Name"){
				$tablename = $source;
				echo "cont";
				continue;
			}*/
			if(!file_exists($source)){
				continue;
			}
			else{
			$timestamp = filemtime($source);
			$check = "SELECT * FROM `$tablename` Where Filename = '$key' ORDER BY id DESC LIMIT 1";
			$result = mysqli_query($dbconn, $check) or die("EROR WHILE CHECKING" . PHP_EOL);
			$row = mysqli_fetch_assoc($result);
			if($row['timestamp'] != $timestamp){
				$hit++;
				$cv = $row['CurrentVersion'] + 1;
				echo "CURRENT" . $cv .PHP_EOL;
				//$fulltarname = $tarname . '.gz';
				//echo $fulltarname . PHP_EOL;
				//$sql = "INSERT INTO `$tablename`(`Filename`,`tarname`, `timestamp`, `CurrentVersion`) VALUES ('$key','$fulltarname', '$timestamp', '$cv') ";
				$sql = "INSERT INTO `$tablename`(`Filename`, `timestamp`, `CurrentVersion`) VALUES ('$key','$timestamp', '$cv') ";
				//copy($source, __DIR__.'/update/'.$key);
				if(!mysqli_query($dbconn,$sql)){
					echo "Update to DB failed $sql". PHP_EOL;
					return false;
					die("Update to DB failed". PHP_EOL);
				}
			}
			exec("cp -p $source " .__DIR__."/update/".$key);
			echo "File $source was added to the /update/" .PHP_EOL;
				
			//echo 'Key: ' .$key . PHP_EOL;
			//echo $val . PHP_EOL;
			}
		}

		exec("cp -p $PathToini " .__DIR__."/update/bundle.ini");

	}
	
	}
		if($hit > 0){
			$tarname = $NameOfTask.$cv.'.tar';
			$archive = new PharData($tarname);
			$fulltarname = $tarname. '.gz';
			$s = "UPDATE `AllTasks` SET `Taskname`='$NameOfTask',`tarname`='$fulltarname',`CurrentVersion`=$cv,`timestamp`=$timestamp WHERE Taskname ='$NameOfTask'";
			//$s = "UPDATE `AllTasks` SET `Taskname`=$NameOfTask,`tarname`=$fulltarname,`CurrentVersion`=$cv,`timestamp`=$timestamp WHERE Taskname ='$NameOfTask'";
			//echo $s . PHP_EOL;
			if(!mysqli_query($dbconn,$s)){
					//return false;
					die("Update to DB failed". PHP_EOL);
				}
			$archive->buildFromDirectory(dirname(__FILE__) . '/update');
			$archive->compress(Phar::GZ);
			unlink($tarname);
			exec('rm -r update');
			shell_exec("scp $fulltarname prit@10.200.44.140:/home/prit/Downloads/Packages");
			return true;
			
		}
		else{
			return false; 
		}
		//unlink($tarname);
		echo "Done!" .PHP_EOL;

}

function removeDirectory($path) {
	$files = glob($path . '/*');
	foreach ($files as $file) {
		is_dir($file) ? removeDirectory($file) : unlink($file);
	}
	rmdir($path);
	return;
}
/*
function deployBundle($ip,$username, $filename){

//$connection= ssh2_connect($ip,22);
//if (@ssh2_auth_password($connection, 'jeff', 'jeff1234')) {
//echo "Authentication Successful!\n";
//}

 else {
die('Authentication Failed...');
}
if(shell_exec("scp $filename $username@$ip:/home/$username/Downloads/Packages")){
	echo 'done';}
else {echo "failed";}
//ssh2_scp_send($connection, __DIR__.'/RPC_Backend.tar', '/home/RPC_Backend.tar',0777);

echo "Done...".PHP_EOL;

return true;
}*/

echo " [x] Awaiting RPC requests\n";
$callback = function($req) {

    $n1 = ($req->body);
$n=json_decode($n1,true);

	var_dump($n);

$Param;
    if ($n[0] == 'build_bundle'){
		
	$Param=buildBundle($n[1],$n[2],$n[3]);
		
		

}

   elseif ($n[0] == 'deploy_bundle'){

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
$channel->basic_consume('bundle', '', false, false, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();

?>
