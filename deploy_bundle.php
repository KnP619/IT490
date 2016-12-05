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
            'localhost', 5672, 'admin', 'asdfasdf');
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
        $this->channel->basic_publish($msg, '', 'deploy');
        while(!$this->response) {
            $this->channel->wait();
        }
        return intval($this->response);
    }
};
$Deploy_Req=array();
$Deploy_Req[0]=$argv[1]; //rollback or deploy_bundle
$Deploy_Req[1]=$argv[2]; //ip
$Deploy_Req[2]=$argv[3]; //user
$Deploy_Req[3]=$argv[4]; //task
if($argv[1] == NULL OR $argv[2] == NULL OR $argv[3] == NULL OR $argc != 4){
	echo "Usage: php deploy_bundle.php <ip> <user> <Taskname>" . PHP_EOL;
	die();
}
$Deploy_Req_Final=json_encode($Deploy_Req);
$fibonacci_rpc = new FibonacciRpcClient();
$response = $fibonacci_rpc->call($Deploy_Req_Final);
if ($response ==1){
	echo " Bundle deployed to $Deploy_Req[1]";

}

?>
