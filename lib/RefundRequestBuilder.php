<?php
namespace kushki\lib;

use kushki\lib\KushkiRequest;
use kushki\lib\KushkiConstant;

class RefundRequestBuilder extends RequestBuilder {

    private $ticket;
    private $token;
    private $amount;

    function __construct($merchantId, $token, $ticket, $amount) {
        parent::__construct($merchantId);
        $this->url = KushkiConstant::REFUND_URL;
        $this->token = $token;
        $this->amount = $amount;
        $this->ticket = $ticket;
    }

    public function createRequest() {
        $params = array(
            KushkiConstant::PARAMETER_TRANSACTION_TOKEN => $this->token,
            KushkiConstant::PARAMETER_TRANSACTION_TICKET => $this->ticket,
            KushkiConstant::PARAMETER_TRANSACTION_AMOUNT => $this->amount,
            KushkiConstant::PARAMETER_CURRENCY_CODE => $this->currency,
            KushkiConstant::PARAMETER_MERCHANT_ID => $this->merchantId,
            KushkiConstant::PARAMETER_LANGUAGE => $this->language
        );

        $request = new KushkiRequest($this->url, $params, KushkiConstant::CONTENT_TYPE);
        return $request;
    }
}
