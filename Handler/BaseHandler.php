<?php

namespace Kamilwozny\WubookAPIBundle\Handler;

use Kamilwozny\WubookAPIBundle\Client;

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