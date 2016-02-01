<?php

namespace Kamwoz\WubookAPIBundle\Handler;

use Kamwoz\WubookAPIBundle\Client;

class BaseHandler
{
    /**
     * @var Client
     */
    protected $client;

    public function setClient(Client $client)
    {
        $this->client = $client;
    }
}