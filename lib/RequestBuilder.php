<?php
namespace kushki\lib;

use kushki\lib\KushkiRequest;
use kushki\lib\KushkiConstant;

abstract class RequestBuilder {
    protected $url;
    protected $currency = KushkiCurrencies::USD;
    protected $merchantId;
    protected $language = KushkiLanguages::ES;

    function __construct($merchantId) {
        $this->merchantId = $merchantId;
    }

    abstract protected function createRequest();
}
