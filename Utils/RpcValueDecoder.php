<?php

namespace Kamilwozny\WubookAPIBundle\Utils;

use PhpXmlRpc\Value;

class RpcValueDecoder
{
    /**
     * Transforms RpcValue object to simple array
     * @param Value $rpcValue
     *
     * @return array
     */
    public static function parseRpcValue(Value $rpcValue)
    {
        $data = [];
        /** @var Value $val */
        foreach($rpcValue as $key => $val){
            // 2 and 3 = array
            if(in_array($val->mytype, [2, 3])) {
                $data[$key] = static::parseRpcValue($val);
            } else {
                $data[$key] = $val->scalarval();
            }
        }

        return $data;
    }
}