<?php

namespace Kamwoz\WubookAPIBundle\Handler;

use Kamwoz\Exception\WubookException;
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

    /**
     * Create new reservation
     *
     * @param \DateTime $dateFrom
     * @param \DateTime $dateTo
     * @param $rooms array
     * @param $customer array
     * @param $amount
     * @param null $orig
     * @param null $ccard
     * @param int $ancillary
     * @param null $guests
     *
     * @return string new reservation id
     * @throws WubookException
     */
    public function newReservation(
        \DateTime $dateFrom,
        \DateTime $dateTo,
        $rooms,
        $customer,
        $amount,
        $orig = null,
        $ccard = null,
        $ancillary = 0,
        $guests = null
    ) {
        $args = func_get_args();
        $args[0] = $args[0]->format('d/m/Y');
        $args[1] = $args[1]->format('d/m/Y');
        $args[4] = strval($args[4]);

        $response = $this->client->request('new_reservation', $args, true, true);
        $parsedResponse = RpcValueDecoder::parseRpcValue($response->value());

        if($parsedResponse[0] != 0) {
            throw new WubookException($parsedResponse[1], $parsedResponse[0]);
        }

        return $parsedResponse[1];
    }

    /**
     * Reservation cancelation
     * @param $rcode
     *
     * @return bool false on success and exception on failure
     * @throws WubookException
     */
    public function cancelReservation($rcode)
    {
        $response = $this->client->request('cancel_reservation', [$rcode], true, true);
        $parsedResponse = RpcValueDecoder::parseRpcValue($response->value());

        if($parsedResponse[0] != 0) {
            throw new WubookException($parsedResponse[1], $parsedResponse[0]);
        }

        return false;
    }
}