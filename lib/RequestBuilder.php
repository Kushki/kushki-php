<?php
namespace kushki\lib;

use kushki\lib\Request;
use kushki\lib\KushkiConstant;

class RequestBuilder
{

    static public function createChargeRequest($url, $token, $amount, $currency,
                                               $merchantId, $language)
    {
        $params = array(
            KushkiConstant::PARAMETER_TRANSACTION_TOKEN => $token,
            KushkiConstant::PARAMETER_TRANSACTION_AMOUNT => $amount,
            KushkiConstant::PARAMETER_CURRENCY_CODE => $currency,
            KushkiConstant::PARAMETER_MERCHANT_ID => $merchantId,
            KushkiConstant::PARAMETER_LANGUAGE => $language
        );

        $request = new Request($url, $params, KushkiConstant::CONTENT_TYPE);
        return $request;
    }

    static public function createTokenRequest($url, $merchantId, $language, $cardName,
                                              $cardNumber, $expiredMonth,
                                              $expiredYear, $cvc,
                                              $deferred = false, $months = 0)
    {
        $cardInformation = array(KushkiConstant::PARAMETER_CARD_NAME => $cardName,
            KushkiConstant::PARAMETER_CARD_NUMBER => $cardNumber,
            KushkiConstant::PARAMETER_CARD_EXP_MONTH => $expiredMonth,
            KushkiConstant::PARAMETER_CARD_EXP_YEAR => $expiredYear,
            KushkiConstant::PARAMETER_CARD_CVC => $cvc);
        $params = array(KushkiConstant::PARAMETER_CARD => $cardInformation,
            KushkiConstant::PARAMETER_MERCHANT_ID => $merchantId,
            KushkiConstant::PARAMETER_LANGUAGE => $language);
        if ($deferred) {
            $params[KushkiConstant::PARAMETER_DEFERRED] = true;
            $params[KushkiConstant::PARAMETER_MONTHS] = $months;
        }

        $request = new Request($url, $params, KushkiConstant::CONTENT_TYPE);
        return $request;
    }

}
