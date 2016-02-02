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

    /**
     * @param $roomId
     * @return null
     */
    public function roomImages($roomId)
    {
        $response = $this->client->request('room_images', [$roomId], true, true);
        $parsedResponse = RpcValueDecoder::parseRpcValue($response->value());

        if($parsedResponse[0] != 0) {
            return null;
        }

        return $parsedResponse[1];
    }
}