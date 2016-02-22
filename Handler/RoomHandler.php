<?php

namespace Kamwoz\WubookAPIBundle\Handler;

use Kamwoz\WubookAPIBundle\Exception\WubookException;
use Kamwoz\WubookAPIBundle\Utils\ResponseDecoder;

class RoomHandler extends BaseHandler
{
    /**
     * Fetch all rooms from wubook
     *
     * @return mixed
     * @throws WubookException
     */
    public function fetchRooms()
    {
        $response = $this->client->request('fetch_rooms', [], true, true);
        $parsedResponse = ResponseDecoder::decodeResponse($response);

        if($parsedResponse[0] != 0) {
            throw new WubookException($parsedResponse[1], $parsedResponse[0]);
        }

        return $parsedResponse[1];
    }

    /**
     * @param $roomId
     *
     * @return null
     * @throws WubookException
     */
    public function roomImages($roomId)
    {
        $response = $this->client->request('room_images', [$roomId], true, true);
        $parsedResponse = ResponseDecoder::decodeResponse($response);

        if($parsedResponse[0] != 0) {
            throw new WubookException($parsedResponse[1], $parsedResponse[0]);
        }

        return $parsedResponse[1];
    }
}