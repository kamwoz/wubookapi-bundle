<?php

namespace Kamilwozny\WubookAPIBundle;

use Kamilwozny\WubookAPIBundle\Handler\TokenHandler;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

/**
 * Responsibility: perform request to wubook API
 * @package AppBundle\Service\WubookAPI
 */
abstract class Client
{
    /**
     * @var string token used in request
     */
    private $token = null;

    /**
     * @var string url target
     */
    private $apiUrl;

    /**
     * @var int property unique id
     */
    private $propertyId;

    /**
     * @var array credentials used to acquire the token
     */
    protected $credentials = [];

    /**
     * @var TokenHandler
     */
    private $tokenHandler;

    /**
     * @param $username
     * @param $password
     * @param $provider_key
     * @param $apiUrl
     * @param $propertyId
     */
    public function __construct($username, $password, $provider_key, $apiUrl, $propertyId)
    {
        $this->credentials = [
            'username' => $username,
            'password' => $password,
            'provider_key' => $provider_key
        ];
        $this->apiUrl = $apiUrl;
        $this->propertyId = $propertyId;
    }

    /**
     * Perform request to wubook api
     *
     * @param $method
     * @param $args array, NOTICE: order is important here. Example values
     *                   'some string val', 5, 5.0, array()
     * @param bool $passToken true if you want pass token as first parameter
     * @param bool $passPropertyId true if you want pass property id as second parameter
     *
     * @return mixed|\PhpXmlRpc\Value|string
     * @internal param bool|true $useToken true if you want use token from config
     */
    protected function request($method, array $args, $passToken = true, $passPropertyId = true)
    {
        $methodWhitelist = ['acquire_token'];

        if(!in_array($method, $methodWhitelist)) {
            throw new MethodNotAllowedException($methodWhitelist);
        }

        $messageArgs = $passToken ? [new \xmlrpcval($this->token, 'string')] : [];
        $messageArgs[] = $passPropertyId ? new \xmlrpcval($this->propertyId, 'string') : null;

        $server = new \xmlrpc_client($this->apiUrl);

        $messageArgs = array_merge($this->createMessageArg($args));
        $message = new \xmlrpcmsg($method, $messageArgs);

        die(\Kint::dump($server->send($method, $message)->value()));
        return $server->send($message)->value();
    }

    private function createMessageArg($args)
    {
        $messageArgs = [];
        foreach($args as $value) {
            $type = TypeResolver::resolve($value);
            if($type === 'array') {
                $messageArgs[] = $this->createMessageArg($value);
            } else {
                $messageArgs[] = new \xmlrpcval($value, $type);
            }
        }

        return $messageArgs;
    }

    public function setTokenHandler(TokenHandler $tokenHandler)
    {
        $this->tokenHandler = $tokenHandler;
    }

    private function setToken($token)
    {
        $this->token = $token;
    }
}