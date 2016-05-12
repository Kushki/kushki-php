<?php

namespace kushki\lib;

use kushki\lib\HttpHandler;

class Kushki {
    private $merchantId;
    private $language;
    private $currency;
    private $requestHandler;

    /**
     * @param string $merchantId
     * @param string $language
     * @param string $currency
     */
    public function __construct($merchantId, $language = KushkiLanguages::ES, $currency = KushkiCurrencies::USD) {
        $this->merchantId = $merchantId;
        $this->language = $language;
        $this->currency = $currency;
    }

    /**
     * @param string $token
     * @param Amount $amount
     * @return Transaction
     * @throws KushkiException
     */
    public function charge($token, $amount) {
        $chargeRequestBuilder = new ChargeRequestBuilder($this->merchantId, $token, $amount);
        $request = $chargeRequestBuilder->createRequest();

        $this->requestHandler = new ChargeRequestHandler($request);

        return $this->requestHandler->charge();
    }

    /**
     * @param $token
     * @param $amount
     * @param $months
     * @return Transaction
     * @throws KushkiException
     */
    public function deferredCharge($token, $amount, $months) {

        $deferredChargeRequestBuilder = new DeferredChargeRequestBuilder($this->merchantId,
                                                                 $token,
                                                                 $amount,
                                                                 $months);
        $request = $deferredChargeRequestBuilder->createRequest();

        $this->requestHandler = new DeferredChargeRequestHandler($request);

        return $this->requestHandler->deferredCharge();
    }

    /**
     * @param $ticket
     * @param $amount
     * @return Transaction
     * @throws KushkiException
     */
    public function voidCharge($ticket, $amount) {
        $voidRequestBuilder = new VoidRequestBuilder($this->merchantId, $ticket, $amount);
        $request = $voidRequestBuilder->createRequest();

        $this->requestHandler = new VoidRequestHandler($request);

        return $this->requestHandler->voidCharge();
    }

    public function getMerchantId() {
        return $this->merchantId;
    }

    public function getLanguage() {
        return $this->language;
    }

    public function getCurrency() {
        return $this->currency;
    }
}

?>
