<?php namespace SimpleMQ\Handler;

use PhpAmqpLib\Message\AMQPMessage;

/**
 * Sender class
 */
class Sender extends AbstractHandler
{
    /**
     * Sends a AMQP message
     *
     * @param string $queueName
     * @param AMQPMessage $message
     */
    public function sendMessage($queueName, AMQPMessage $message)
    {
        $this->declareQueue($queueName);

        $this->getClient()
             ->getChannel()
             ->basic_publish($message, '', $queueName);
    }
}