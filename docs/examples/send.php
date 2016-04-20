<?php
require_once __DIR__ . '/../../vendor/autoload.php';

$user       = 'guest';
$password   = 'guest';

$client     = \SimpleMQ\Client::getClient($user, $password);
$sender     = \SimpleMQ\Client::getSender($client);

$message    = new \PhpAmqpLib\Message\AMQPMessage('Hello Rabbit');

$sender->sendMessage('test', $message);
$sender->getClient()->close();