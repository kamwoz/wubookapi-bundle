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

    public function newReservation()
    {
        $response = $this->client->request('new_reservation', [], true, true);
        $parsedResponse = RpcValueDecoder::parseRpcValue($response->value());

        if($parsedResponse[0] != 0) {
            return null;
        }
    }
}