<?php

namespace Kamwoz\WubookAPIBundle\Utils;

use PhpXmlRpc\Encoder;
use PhpXmlRpc\Response;

class ResponseDecoder
{
    /**
     * Simple wrapper to Encoder class
     * @param Response $response
     *
     * @return array
     */
    public static function decodeResponse(Response $response)
    {
        $resValue = $response->value();
        if(!empty($response)) {
            $encoder = new Encoder();

            return $encoder->decode($resValue);
        }

        //otherwise return some default error
        return [-111, 'Undefined error (invalid response)'];
    }
}