<?php namespace SimpleMQ\Handler;

use SimpleMQ\Client;

/**
 * Abstract handler
 */
abstract class AbstractHandler
{
    /**
     * Client instance
     *
     * @var Client
     */
    private $client = null;

    /**
     * Constructor
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Returns the client instance
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     *
     * @param type $queueName
     */
    protected function declareQueue($queueName)
    {
        $this->client
             ->getChannel()
             ->queue_declare($queueName, false, false, false, false);
    }
}