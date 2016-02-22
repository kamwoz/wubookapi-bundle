<?php

namespace Kamwoz\WubookAPIBundle\Handler;

use Kamwoz\WubookAPIBundle\Exception\WubookException;
use Kamwoz\WubookAPIBundle\Utils\ResponseDecoder;

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

        $response = $this->client->request('fetch_rooms_values', $args, true, true);
        $parsedResponse = ResponseDecoder::decodeResponse($response);

        if($parsedResponse[0] != 0) {
            throw new WubookException($parsedResponse[1], $parsedResponse[0]);
        }

        return $parsedResponse[1];
    }
}