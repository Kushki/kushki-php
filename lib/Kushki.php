<?php

namespace kushki\lib;

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
     * @param string $currency
     */
    public function __construct($merchantId, $language = KushkiLanguages::ES, $currency = KushkiCurrencies::USD)
    {
        $this->merchantId = $merchantId;
        $this->language = $language;
        $this->currency = $currency;
    }

    /**
     * @param string $token
     * @param float $amount
     * @return KushkiResponse
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
