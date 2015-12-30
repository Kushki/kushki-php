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
     * @param $cardParams
     * @return KushkiResponse
     */
    public function requestToken($cardParams) {
        $tokenRequestBuilder = new TokenRequestBuilder($this->merchantId, $cardParams);
        $request = $tokenRequestBuilder->createRequest();

        $this->requestHandler = new TokenRequestHandler($request);

        return$this->requestHandler->requestToken();
    }

    /**
     * @param string $token
     * @param float $amount
     * @return KushkiResponse
     * @throws KushkiException
     */
    public function charge($token, $amount) {
        $validAmount = $this->validateAmount($amount);

        $chargeRequestBuilder = new ChargeRequestBuilder($this->merchantId, $token, $validAmount);
        $request = $chargeRequestBuilder->createRequest();

        $this->requestHandler = new ChargeRequestHandler($request);

        return $this->requestHandler->charge();
    }

    private function validateAmount($amount) {
        if ($amount == null) {
            throw new KushkiException("El monto no puede ser nulo");
        }
        if ($amount <= 0) {
            throw new KushkiException("El monto debe ser superior a 0");
        }
        $validAmount = number_format($amount, 2, ".", "");
        if (strlen($validAmount) > 12) {
            throw new KushkiException("El monto debe tener menos de 12 dígitos");
        }
        return $validAmount;
    }

    public function getMerchantId() {
        return $this->merchantId;
    }

}

?>
