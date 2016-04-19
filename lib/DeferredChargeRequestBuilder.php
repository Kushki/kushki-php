<?php
namespace kushki\lib;

use kushki\lib\KushkiRequest;
use kushki\lib\KushkiConstant;

class DeferredChargeRequestBuilder extends RequestBuilder {

    private $token;
    private $amount;
    private $months;
    private $interest;

    function __construct($merchantId, $token, $amount, $months) {
        parent::__construct($merchantId);
        $this->url = KushkiConstant::DEFERRED_URL;
        $this->token = $token;
        $this->amount = $amount;
        $this->months = $months;
    }

    public function createRequest() {
        $params = array(
            KushkiConstant::PARAMETER_TRANSACTION_TOKEN => $this->token,
            KushkiConstant::PARAMETER_TRANSACTION_AMOUNT => $this->amount->toHash(),
            KushkiConstant::PARAMETER_MONTHS => $this->months,
            KushkiConstant::PARAMETER_INTEREST => $this->interest,
            KushkiConstant::PARAMETER_CURRENCY_CODE => $this->currency,
            KushkiConstant::PARAMETER_MERCHANT_ID => $this->merchantId,
            KushkiConstant::PARAMETER_LANGUAGE => $this->language
        );

        $request = new KushkiRequest($this->url, $params, KushkiConstant::CONTENT_TYPE);
        return $request;
    }
}
