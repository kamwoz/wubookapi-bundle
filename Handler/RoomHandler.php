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
     * Add new room to wubook
     *
     * @param $woodoo
     * @param $name
     * @param $beds
     * @param $price
     * @param $avail
     * @param $shortname
     * @param $defboard
     * @param array $names
     * @param array $descriptions
     * @param array $boards
     * @param int $rtype
     * @param int $min_price
     * @param int $max_price
     *
     * @return int
     * @throws WubookException
     */
    public function addRoom(
        $woodoo,
        $name,
        $beds,
        $price,
        $avail,
        $shortname,
        $defboard,
        $names = array(),
        $descriptions = array(),
        $boards = array(),
        $rtype = 1,
        $min_price = 0,
        $max_price = 0
    )
    {
        return parent::defaultRequestHandler('new_room', [
            $woodoo,
            $name,
            $beds,
            $price,
            $avail,
            $shortname,
            $defboard,
            $names,
            $descriptions,
            $boards,
            $rtype,
            $min_price,
            $max_price
        ]);
    }

    /**
     * Update existing room on wubook
     *
     * @param $roomId
     * @param $name
     * @param $beds
     * @param $price
     * @param $avail
     * @param $shortname
     * @param $defboard
     * @param array $names
     * @param array $descriptions
     * @param array $boards
     * @param int $min_price
     * @param int $max_price
     *
     * @return int
     * @throws WubookException
     */
    public function updateRoom(
        $roomId,
        $name,
        $beds,
        $price,
        $avail,
        $shortname,
        $defboard,
        $names = array(),
        $descriptions = array(),
        $boards = array(),
        $min_price = 0,
        $max_price = 0
    )
    {
        return parent::defaultRequestHandler('mod_room', func_get_args());
    }

    /**
     * Delete existing room from wubook
     *
     * @param $roomId
     *
     * @return int
     * @throws WubookException
     */
    public function deleteRoom($roomId)
    {
        return parent::defaultRequestHandler('del_room', [$roomId]);
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