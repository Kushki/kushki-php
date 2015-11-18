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

}
