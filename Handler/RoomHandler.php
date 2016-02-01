<?php

namespace Kamwoz\WubookAPIBundle\Handler;

use Kamwoz\WubookAPIBundle\Utils\RpcValueDecoder;

class RoomHandler extends BaseHandler
{
    public function fetchRooms()
    {
        $response = $this->client->request('fetch_rooms', [], true, true);
        $parsedResponse = RpcValueDecoder::parseRpcValue($response->value());

        if($parsedResponse[0] != 0) {
            return null;
        }

        return $parsedResponse[1];
    }
}