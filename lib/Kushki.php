<?php

namespace kushki\lib;

use kushki\lib\ChargeRequestHandler;
use kushki\lib\RequestBuilder;
use kushki\lib\HttpHandler;
use kushki\lib\KushkiConstant;

class Kushki
{

    private $merchantId;
    private $language;
    private $currency;
    private $chargeHandler;

    /**
     * @param string $merchantId
     * @param string $language
     * @param stringt $currency
     */
    public function __construct($merchantId, $language, $currency)
    {
        $this->merchantId = $merchantId;
        $this->language = $language;
        $this->currency = $currency;
    }

    /**
     * @param string $token
     * @param float $amount
     */
    public function charge($token, $amount)
    {
        $request = RequestBuilder::createChargeRequest(KushkiConstant::CHARGE_URL,
            $token, $amount, $this->currency,
            $this->merchantId, $this->language);


        $this->chargeHandler = new ChargeRequestHandler($request);

        return $this->chargeHandler->charge();
    }

    public function getMerchantId()
    {
        return $this->merchantId;
    }

}

?>
