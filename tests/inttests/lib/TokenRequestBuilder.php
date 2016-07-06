<?php
namespace kushki\tests\inttests\lib;


use kushki\lib\KushkiRequest;
use kushki\lib\KushkiConstant;
use kushki\lib\RequestBuilder;
use kushki\lib\KushkiEnvironment;

class TokenRequestBuilder extends RequestBuilder {

    private $cardName;
    private $cardNumber;
    private $cardExpiryMonth;
    private $cardExpiryYear;
    private $cardCvv;
    private $amount;

    function __construct($merchantId, $cardParams, $baseUrl = KushkiEnvironment::PRODUCTION) {
        parent::__construct($merchantId);
        $this->url = $baseUrl . KushkiConstant::TOKENS_URL;
        $this->cardName = $cardParams["name"];
        $this->cardNumber = $cardParams["number"];
        $this->cardExpiryMonth = $cardParams["expiry_month"];
        $this->cardExpiryYear = $cardParams["expiry_year"];
        $this->cardCvv = $cardParams["cvv"];
        $this->amount = $cardParams["amount"];
    }

    public function createRequest() {
        $params = array(
            KushkiConstant::PARAMETER_CURRENCY_CODE => $this->currency,
            KushkiConstant::PARAMETER_MERCHANT_ID => $this->merchantId,
            KushkiConstant::PARAMETER_LANGUAGE => $this->language,
            "card" => array(
                "name" => $this->cardName,
                "number" => $this->cardNumber,
                "expiry_month" => $this->cardExpiryMonth,
                "expiry_year" => $this->cardExpiryYear,
                "cvv" => $this->cardCvv
            ),
            "amount" => $this->amount->toHash()["Total_amount"],
            "remember_me" => '0'
        );
        $request = new KushkiRequest($this->url, $params, KushkiConstant::CONTENT_TYPE);
        return $request;
    }
}
