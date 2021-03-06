<?php

namespace Kamwoz\WubookAPIBundle\Handler;

use Kamwoz\WubookAPIBundle\Exception\WubookException;

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
     * @throws WubookException
     */
    public function fetchBookings(\DateTime $dateFrom, \DateTime $dateTo, $byReservationDate = 1, $ancillary = 0)
    {
        $args = [
            $dateFrom->format('d/m/Y'),
            $dateTo->format('d/m/Y'),
            $byReservationDate,
            $ancillary
        ];

        return parent::defaultRequestHandler('fetch_bookings', $args);
    }

    /**
     * Fetch single booking
     *
     * @param $reservationId
     * @param int $ancillary
     *
     * @return null
     * @throws WubookException
     */
    public function fetchBooking($reservationId, $ancillary = 0)
    {
        $res = parent::defaultRequestHandler('fetch_booking', [$reservationId, $ancillary]);

        return $res[0];
    }

    /**
     * Create new reservation
     *
     * @param \DateTime $dateFrom
     * @param \DateTime $dateTo
     * @param $rooms    array
     * @param $customer array
     * @param $amount
     * @param null $orig
     * @param null $ccard
     * @param int $ancillary
     * @param null $guests
     * @param int $ignore_restr
     * @param int $ignore_avail
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
        $guests = null,
        $ignore_restr = 0,
        $ignore_avail = 0
    ) {
        $args = func_get_args();
        $args[0] = $args[0]->format('d/m/Y');
        $args[1] = $args[1]->format('d/m/Y');
        $args[4] = strval($args[4]);
        
        return parent::defaultRequestHandler('new_reservation', $args);
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
        parent::defaultRequestHandler('cancel_reservation', [$rcode]);

        return false;
    }

    /**
     * @param int $ancillary
     * @param int $mark
     * @return mixed
     * @throws WubookException
     */
    public function fetchNewBooking($ancillary = 0, $mark = 1)
    {
        $args = [
            $ancillary,
            $mark
        ];

        return parent::defaultRequestHandler('fetch_new_bookings', $args);
    }

    /**
     * @param $url
     *
     * @return mixed
     * @throws WubookException
     */
    public function pushActivation( $url )
    {
        return parent::defaultRequestHandler('push_activation', [ $url ]);
    }

    /**
     * @return mixed
     * @throws WubookException
     */
    public function pushURL()
    {
        return parent::defaultRequestHandler('push_url', []);
    }

    /**
     * @param $reservations
     *
     * @return mixed
     * @throws WubookException
     */
    public function markBookings( $reservations )
    {
        return parent::defaultRequestHandler('mark_bookings', [$reservations] );
    }
}