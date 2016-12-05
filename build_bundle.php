<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class FibonacciRpcClient {
    private $connection;
    private $channel;
    private $callback_queue;
    private $response;
    private $corr_id;

    public function __construct() {
        $this->connection = new AMQPStreamConnection(
            '10.200.44.168', 5672, 'admin', 'knp33');
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

    public function call($n) {
        $this->response = null;
        $this->corr_id = uniqid();

        $msg = new AMQPMessage(
            (string) $n,
            array('correlation_id' => $this->corr_id,
                  'reply_to' => $this->callback_queue)
            );
        $this->channel->basic_publish($msg, '', 'bundle');
        while(!$this->response) {
            $this->channel->wait();
        }
        return intval($this->response);
    }
};

$Deploy_Req=array();
$Deploy_Req[0]='build_bundle';
$Deploy_Req[1]= $argv[1]; //first ini file
$Deploy_Req[2]= $argv[2]; // name of the file
$Deploy_Req[3]= $argv[3]; // name of the task
$Deploy_Req_Final=json_encode($Deploy_Req);

$fibonacci_rpc = new FibonacciRpcClient();
if($argv[1] == NULL OR $argv[2] == NULL OR $argc != 3){
	echo "Usage: php build_bundle.php <inipath> <taskname>" . PHP_EOL;
	die();
}
$response = $fibonacci_rpc->call($Deploy_Req_Final);
if ($response ==1){
echo " [.] Bundle build successfull...\n";
}
else{
	exit("Failed to build bundle");
}
?>
