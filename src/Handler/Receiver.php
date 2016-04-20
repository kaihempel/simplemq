<?php namespace SimpleMQ\Handler;

use PhpAmqpLib\Message\AMQPMessage;
use Exception;

/**
 * Receiver class
 */
class Receiver extends AbstractHandler
{
    /**
     * Fetch one message from the given channel
     *
     * @param type $queueName
     * @return type
     * @throws Exception
     */
    public function receive($queueName)
    {
        $this->declareQueue($queueName);

        $msg = $this->getClient()
                    ->getChannel()
                    ->basic_get($queueName);

        // Check on AMQP message instance

        if ($msg instanceof AMQPMessage) {

            if (isset($msg->delivery_info['delivery_tag'])) {
                $deliveryTag = $msg->delivery_info['delivery_tag'];
            } else {
                $deliveryTag = 0;
            }

            $this->sendAck($deliveryTag);
            return $msg->getBody();
        }

        // No expected message

        $this->sendNack();
        throw new Exception('No message received!');
    }

    /**
     * Send a acknolege message
     *
     * @param type $deliveryTag
     */
    public function sendAck($deliveryTag)
    {
        $this->getClient()
             ->getChannel()
             ->basic_ack($deliveryTag);
    }

    /**
     * Send a not acknolege message
     *
     * @param type $deliveryTag
     */
    public function sendNack($deliveryTag = 0)
    {
        $this->getClient()
             ->getChannel()
             ->basic_nack($deliveryTag);
    }
}