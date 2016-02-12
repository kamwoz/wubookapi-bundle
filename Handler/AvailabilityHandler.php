<?php

namespace Kamwoz\WubookAPIBundle\Handler;

use Kamwoz\WubookAPIBundle\Utils\RpcValueDecoder;

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
     */
    public function fetchRoomValues(\DateTime $dateFrom, \DateTime $dateTo, $rooms = array())
    {
        $args = [
            $dateFrom->format('d/m/Y'),
            $dateTo->format('d/m/Y'),
            $rooms
        ];

        $response = $this->client->request('fetch_rooms_values', $args, true, true);
        $parsedResponse = RpcValueDecoder::parseRpcValue($response->value());

        if($parsedResponse[0] != 0) {
            return null;
        }

        return $parsedResponse[1];
    }
}