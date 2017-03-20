<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 3/14/17
 * Time: 4:38 PM
 */

namespace kushki\lib;

use HttpException;
use HttpRequest;

class KushkiClient
{

    function callAPI($method, $url, $data)
    {
        $responseRaw = \Httpful\Request::post($url)
            ->sendsJson()
            ->withStrictSSL()
            ->addHeaders(array(
                'private-merchant-id' => $data["private-merchant-id"]
            ))
                ->body(json_encode($data["body"]))
            ->send();
        return new Transaction($responseRaw->content_type, $responseRaw->body, $responseRaw->code);
    }

    function callCharge($url, $data)
    {
        $url = $url . KushkiConstant::CHARGE_API_URL;
        $method = 'POST';
        $requestCharge = $this->callAPI($method,$url,$data);
        return $requestCharge;
    }
}

?>