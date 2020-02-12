<?php
require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');

for ($i = 0; $i < 100000; $i++) {
    echo $i . '\t';
    $channel = $connection->channel();
    $channel->queue_declare('hello', false, false, false, false);
    $msg = new AMQPMessage("Hello world! $i");
    $channel->basic_publish($msg, '', 'hello');
    echo " [x] Sent 'Hello world!'\n";
    $channel->close();
}

$connection->close();