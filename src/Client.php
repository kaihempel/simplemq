<?php namespace SimpleMQ;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use SimpleMQ\Handler\Sender;
use SimpleMQ\Handler\Receiver;

/**
 * Simple RabbitMQ client
 */
class Client
{
    /**
     * Connection instance
     *
     * @var AMQPStreamConnection
     */
    private $connection = null;

    /**
     * Constructor
     *
     * @param AMQPStreamConnection $connection
     */
    public function __construct(AMQPStreamConnection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Returns the channel instance
     *
     * @param int $cid
     * @return type
     */
    public function getChannel($cid = null)
    {
        if (empty($cid)) {
            $cid = 1;
        }

        return $this->connection->channel();
    }

    /**
     * Close the connection
     *
     * @return void
     */
    public function close()
    {
        $this->getChannel()->close();
        $this->connection->close();
    }

    /**
     * Returns a new client instance
     *
     * @param string $user
     * @param string $password
     * @param string $host
     * @param integer $port
     * @return Client
     */
    public static function getClient($user, $password, $host = 'localhost', $port = 5672)
    {
        return new Client(new AMQPStreamConnection($host, $port, $user, $password));
    }

    /**
     * Returns a new sender instance
     *
     * @return Sender
     */
    public static function getSender(Client $client)
    {
        return new Sender($client);
    }

    /**
     * Returns a new receiver instance
     *
     * @return Receiver
     */
    public static function getReceiver(Client $client)
    {
        return new Receiver($client);
    }

}