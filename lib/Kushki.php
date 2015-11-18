<?php

namespace kushki\lib;

use kushki\lib\ChargeRequestHandler;
use kushki\lib\RequestBuilder;
use kushki\lib\CurlHandler;
use kushki\lib\KushkiConstant;

class Kushki
{

    private $merchantId;
    private $language;
    private $currency;
    private $chargeHandler;

    public function __construct($merchantId, $language, $currency)
    {
        $this->merchantId = $merchantId;
        $this->language = $language;
        $this->currency = $currency;
        $curlHandler = new CurlHandler();
        $this->chargeHandler = new ChargeRequestHandler($curlHandler);
    }

    public function charge($token, $amount)
    {
        $request = RequestBuilder::createChargeRequest(KushkiConstant::CHARGE_URL,
            $token, $amount, $this->currency,
            $this->merchantId, $this->language);

        return $this->chargeHandler->charge($request);
    }

    public function getMerchantId()
    {
        return $this->merchantId;
    }

}

?>
