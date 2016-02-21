<?php

namespace Kamwoz\WubookAPIBundle;

use Kamwoz\WubookAPIBundle\Handler\TokenHandler;
use Kamwoz\WubookAPIBundle\Utils\TokenProviderInterface;
use PhpXmlRpc\Encoder;
use PhpXmlRpc\Request;
use PhpXmlRpc\Value;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

/**
 * Responsibility: perform request to wubook API
 * @package AppBundle\Service\WubookAPI
 */
class Client
{
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
    public $credentials = [];

    /**
     * @var TokenHandler
     */
    private $tokenHandler;

    /**
     * @var TokenProviderInterface
     */
    public $tokenProvider;

    private $methodWhitelist = [
        'acquire_token', 'release_token', 'is_token_valid', 'provider_info',
        'fetch_rooms', 'room_images', 'new_reservation', 'fetch_bookings',
        'fetch_booking', 'fetch_rooms_values'
    ];

    /**
     * @param TokenProviderInterface $tokenProvider
     * @param $username
     * @param $password
     * @param $provider_key
     * @param $apiUrl
     * @param $propertyId
     */
    public function __construct(TokenProviderInterface $tokenProvider, $username, $password, $provider_key, $apiUrl, $propertyId)
    {
        $this->tokenProvider = $tokenProvider;
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
     * @param $args                array, NOTICE: order is important here
     * @param bool $passToken      true if you want pass token as first parameter
     * @param bool $passPropertyId true if you want pass property id as second parameter
     * @param bool $tryAcquireNewToken
     *
     * @return mixed|Value|string
     * @internal param bool|true $useToken true if you want use token from config
     */
    public function request($method, array $args, $passToken = true, $passPropertyId = true, $tryAcquireNewToken = true)
    {
        if(!in_array($method, $this->methodWhitelist)) {
            throw new MethodNotAllowedException($this->methodWhitelist, 'Method not allowed, allowed: ' . join(', ', $this->methodWhitelist));
        }

        $requestArgs = $passToken ? [$this->tokenProvider->getToken()] : [];
        if($passPropertyId) {
            $requestArgs[] = (string) $this->propertyId;
        }

        $server = new \PhpXmlRpc\Client($this->apiUrl);

        $encoder = new Encoder();
        $args = array_merge($requestArgs, $args);
        foreach($args as $arg) {
            $requestArgs[] = $encoder->encode($arg);
        }
        $request = new Request($method, $requestArgs);

        $response =  $server->send($request);

        $isResponseOK = !empty($response->value()) && (int) $response->value()->me['array'][0]->scalarval() == 0;
        if(!$isResponseOK && $tryAcquireNewToken) {
            $this->tokenHandler->acquireToken();
            return self::request($method, $args, $passToken, $passPropertyId, false);
        } else {
            return $response;
        }
    }

    public function setTokenHandler(TokenHandler $tokenHandler)
    {
        $this->tokenHandler = $tokenHandler;
    }
}