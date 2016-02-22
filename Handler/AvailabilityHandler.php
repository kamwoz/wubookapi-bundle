<?php

namespace Kamwoz\WubookAPIBundle\Handler;

use Kamwoz\WubookAPIBundle\Exception\WubookException;

class AvailabilityHandler extends BaseHandler
{
    /**
     * Fetch availability
     *
     * @param \DateTime $dateFrom
     * @param \DateTime $dateTo
     * @param array $rooms array with room ids (integers)
     *
     * @return array|null
     * @throws WubookException
     */
    public function fetchRoomValues(\DateTime $dateFrom, \DateTime $dateTo, $rooms = array())
    {
        $args = [
            $dateFrom->format('d/m/Y'),
            $dateTo->format('d/m/Y'),
            $rooms
        ];

        return parent::defaultRequestHandler('fetch_rooms_values', $args);
    }

    /**
     * @param $dateFrom \DateTime
     * @param $roomDays
     *
     * @return
     * @throws WubookException
     */
    public function updateAvail(\DateTime $dateFrom, $roomDays)
    {
        $args = [
            $dateFrom->format('d/m/Y'),
            $roomDays
        ];

        return parent::defaultRequestHandler('update_avail', $args);
    }
}