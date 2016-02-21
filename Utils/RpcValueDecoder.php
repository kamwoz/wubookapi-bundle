<?php

namespace Kamwoz\WubookAPIBundle\Utils;

use PhpXmlRpc\Encoder;
use PhpXmlRpc\Value;

class RpcValueDecoder
{
    /**
     * Simple wrapper to Encoder class
     * @param Value $rpcValue
     *
     * @return array
     */
    public static function parseRpcValue(Value $rpcValue)
    {
        $encoder = new Encoder();
        $data = $encoder->decode($rpcValue);

        return $data;
    }
}