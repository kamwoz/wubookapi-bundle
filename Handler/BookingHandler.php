<?php

namespace Kamwoz\WubookAPIBundle\Handler;

use Kamwoz\WubookAPIBundle\Utils\RpcValueDecoder;

class BookingHandler extends BaseHandler
{
    /**
     * Fetch reservations from wubook
     *
     * @param \DateTime $dateFrom
     * @param \DateTime $dateTo
     * @param int $byReservationDate
     * @param int $ancillary
     *
     * @return array|null
     */
    public function fetchBookings(\DateTime $dateFrom, \DateTime $dateTo, $byReservationDate = 1, $ancillary = 0)
    {
        $args = [
            $dateFrom->format('d/m/Y'),
            $dateTo->format('d/m/Y'),
            $byReservationDate,
            $ancillary
        ];

        $response = $this->client->request('fetch_bookings', $args, true, true);
        $parsedResponse = RpcValueDecoder::parseRpcValue($response->value());

        if($parsedResponse[0] != 0) {
            return null;
        }

        return $parsedResponse[1];
    }

    /**
     * Fetch single booking
     *
     * @param $reservationId
     * @param int $ancillary
     *
     * @return null
     */
    public function fetchBooking($reservationId, $ancillary = 0)
    {
        $response = $this->client->request('fetch_booking', [$reservationId, $ancillary], true, true);
        $parsedResponse = RpcValueDecoder::parseRpcValue($response->value());

        if($parsedResponse[0] != 0) {
            return null;
        }

        return $parsedResponse[1][0];
    }

    public function newReservation()
    {
        $response = $this->client->request('new_reservation', [], true, true);
        $parsedResponse = RpcValueDecoder::parseRpcValue($response->value());

        if($parsedResponse[0] != 0) {
            return null;
        }//todo
    }
}