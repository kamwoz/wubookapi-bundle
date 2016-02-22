<?php

namespace Kamwoz\WubookAPIBundle\Handler;

use Kamwoz\WubookAPIBundle\Client;
use Kamwoz\WubookAPIBundle\Exception\WubookException;
use Kamwoz\WubookAPIBundle\Utils\ResponseDecoder;

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

    public function defaultRequestHandler($method, $args, $passToken = true, $passPropertyId = true, $tryAcquireNewToken = true)
    {
        $response = $this->client->request($method, $args, $passToken, $passPropertyId, $tryAcquireNewToken);
        $parsedResponse = ResponseDecoder::decodeResponse($response);

        if($parsedResponse[0] != 0) {
            throw new WubookException($parsedResponse[1], $parsedResponse[0]);
        }

        return $parsedResponse[1];
    }
}