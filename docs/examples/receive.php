<?php
require_once __DIR__ . '/../../vendor/autoload.php';

$user       = 'guest';
$password   = 'guest';

$client     = \SimpleMQ\Client::getClient($user, $password);
$receiver   = \SimpleMQ\Client::getReceiver($client);

$msg = $receiver->receive('test');

var_dump($msg);
