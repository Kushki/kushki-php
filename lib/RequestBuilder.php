<?php
namespace kushki\lib;

use kushki\lib\KushkiRequest;
use kushki\lib\KushkiConstant;

class RequestBuilder {
    protected $url;
    protected $token;
    protected $amount;
    protected $currency = KushkiCurrencies::USD;
    protected $merchantId;
    protected $language = KushkiLanguages::ES;

    public function createRequest() {
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
