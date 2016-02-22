<?php

namespace Kamwoz\WubookAPIBundle\Handler;

use Kamwoz\WubookAPIBundle\Exception\WubookException;

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
        return parent::defaultRequestHandler('fetch_rooms', []);
    }

    /**
     * @param $roomId
     *
     * @return null
     * @throws WubookException
     */
    public function roomImages($roomId)
    {
        return parent::defaultRequestHandler('room_images', [$roomId]);
    }
}