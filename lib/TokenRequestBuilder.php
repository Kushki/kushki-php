<?php
namespace kushki\lib;

use kushki\lib\KushkiRequest;
use kushki\lib\KushkiConstant;

class TokenRequestBuilder extends RequestBuilder {

    private $cardName;
    private $cardNumber;
    private $cardExpiryMonth;
    private $cardExpiryYear;
    private $cardCvv;

    function __construct($merchantId, $cardParams) {
        parent::__construct($merchantId);
        $this->url = KushkiConstant::TOKENS_URL;
        $this->cardName = $cardParams[KushkiConstant::PARAMETER_CARD_NAME];
        $this->cardNumber = $cardParams[KushkiConstant::PARAMETER_CARD_NUMBER];
        $this->cardExpiryMonth = $cardParams[KushkiConstant::PARAMETER_CARD_EXP_MONTH];
        $this->cardExpiryYear = $cardParams[KushkiConstant::PARAMETER_CARD_EXP_YEAR];
        $this->cardCvv = $cardParams[KushkiConstant::PARAMETER_CARD_CVC];
    }

    public function createRequest() {
        $params = array(
            KushkiConstant::PARAMETER_CURRENCY_CODE => $this->currency,
            KushkiConstant::PARAMETER_MERCHANT_ID => $this->merchantId,
            KushkiConstant::PARAMETER_LANGUAGE => $this->language,
            KushkiConstant::PARAMETER_CARD => array(
                KushkiConstant::PARAMETER_CARD_NAME => $this->cardName,
                KushkiConstant::PARAMETER_CARD_NUMBER => $this->cardNumber,
                KushkiConstant::PARAMETER_CARD_EXP_MONTH => $this->cardExpiryMonth,
                KushkiConstant::PARAMETER_CARD_EXP_YEAR => $this->cardExpiryYear,
                KushkiConstant::PARAMETER_CARD_CVC => $this->cardCvv
            )
        );
        $request = new KushkiRequest($this->url, $params, KushkiConstant::CONTENT_TYPE);
        return $request;
    }
}
