<?php

namespace kushki\app\lib;

use kushki\app\lib\ChargeRequestHandler;
use kushki\app\lib\RequestBuilder;
use kushki\app\lib\CurlHandler;
use kushki\app\lib\KushkiConstant;

class Kushki
{

    private $merchantId;
    private $language;
    private $currency;

    public function __construct($merchantId, $language, $currency)
    {
        $this->merchantId = $merchantId;
        $this->language = $language;
        $this->currency = $currency;
    }

    public function charge($token, $amount)
    {
        $curlHandler = new CurlHandler();
        $chargeHandler = new ChargeRequestHandler($curlHandler);
        $request = RequestBuilder::createChargeRequest(KushkiConstant::CHARGE_URL,
            $token, $amount, $this->currency,
            $this->merchantId, $this->language);

        $response = $chargeHandler->charge($request);
        return $response;
    }

    public function getToken($url, $cardName, $cardNumber, $expiredMonth,
                             $expiredYear, $cvc, $deferred = false, $months = 0)
    {
        $curlHandler = new CurlHandler();
        $chargeHandler = new TokenRequestHandler($curlHandler);
        $request = RequestBuilder::createTokenRequest(KushkiConstant::GET_TOKEN_URL,
            $this->merchantId, $this->language, $cardName,
            $cardNumber, $expiredMonth,
            $expiredYear, $cvc,
            $deferred, $months);

        $response = $chargeHandler->getToken($request);
        return $response;
    }

    public function getMerchantId()
    {
        return $this->merchantId;
    }

}

?>
