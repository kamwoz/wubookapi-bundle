<?php

namespace Kamilwozny\WubookAPIBundle\Handler;

class ReservationHandler extends BaseHandler
{
    /**
     * Fetch reservations from wubook and put it to our db
     * This function will not override existing reservations (with same id)
     *
     * @param int $limit 0 = no limit
     * @param bool $returnValue if you need to use
     *                          these reservations they will be returned
     */
    public function fetchReservations($limit = 0, $returnValue = false)
    {

    }
}