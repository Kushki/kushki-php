<?php

namespace kushki\lib;

use kushki\lib\ChargeRequestHandler;
use kushki\lib\KushkiConstant;
use kushki\lib\RequestBuilder;
use kushki\lib\HttpHandler;

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
        $builder = new RequestBuilder();
        $builder->setCurrency($this->currency);
        $builder->setLanguage($this->language);
        $builder->setMerchantId($this->merchantId);
        $builder->setAmount($amount);
        $builder->setToken($token);
        $builder->setUrl(KushkiConstant::CHARGE_URL);
        $request = $builder->createChargeRequest();

        $this->chargeHandler = new ChargeRequestHandler($request);

        return $this->chargeHandler->charge();
    }

    public function getMerchantId()
    {
        return $this->merchantId;
    }

}

?>
