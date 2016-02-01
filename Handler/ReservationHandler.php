<?php

namespace Kamwoz\WubookAPIBundle\Handler;

use Kamwoz\WubookAPIBundle\Utils\RpcValueDecoder;

class ReservationHandler extends BaseHandler
{
    /**
     * Fetch reservations from wubook and put it to our db
     * This function will not override existing reservations (with same id)
     *
     */
    public function fetchReservations()
    {
    }
}