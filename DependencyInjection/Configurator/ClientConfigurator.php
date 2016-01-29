<?php

namespace Kamilwozny\WubookAPIBundle\DependencyInjection\Configurator;

use Kamilwozny\WubookAPIBundle\Client;
use Kamilwozny\WubookAPIBundle\Handler\TokenHandler;

/**
 * Configure the Client class to avoid circular reference
 * @package Kamilwozny\WubookAPIBundle\DependencyInjection\Configurator
 */
class ClientConfigurator
{
    /**
     * @var TokenHandler
     */
    private $tokenHandler;

    public function __construct(TokenHandler $tokenHandler)
    {
        $this->tokenHandler = $tokenHandler;
    }

    public function configure(Client $client)
    {
        $client->setTokenHandler($this->tokenHandler);
    }
}