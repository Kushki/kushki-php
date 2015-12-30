<?php
namespace kushki\lib;

use kushki\lib\KushkiRequest;
use kushki\lib\KushkiConstant;

class ChargeRequestBuilder extends RequestBuilder {

    function __construct($merchantId, $token, $amount) {
        $this->url = KushkiConstant::CHARGE_URL;
        $this->merchantId = $merchantId;
        $this->token = $token;
        $this->amount = $amount;
    }

    public function createRequest() {
        $params = array(
            KushkiConstant::PARAMETER_TRANSACTION_TOKEN => $this->token,
            KushkiConstant::PARAMETER_TRANSACTION_AMOUNT => $this->amount,
            KushkiConstant::PARAMETER_CURRENCY_CODE => $this->currency,
            KushkiConstant::PARAMETER_MERCHANT_ID => $this->merchantId,
            KushkiConstant::PARAMETER_LANGUAGE => $this->language
        );

        $request = new KushkiRequest($this->url, $params, KushkiConstant::CONTENT_TYPE);
        return $request;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function setToken($token) {
        $this->token = $token;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function setCurrency($currency) {
        $this->currency = $currency;
    }

    public function setMerchantId($merchantId) {
        $this->merchantId = $merchantId;
    }

    public function setLanguage($language) {
        $this->language = $language;
    }
}
