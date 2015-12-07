<?php

namespace kushki\lib;

class KushkiConstant
{
    const VERSION = '1.0';
    const CHARGE_URL = "https://ping.auruspay.com/kushki/api/v1/charge";
    const PARAMETER_MERCHANT_ID = "merchant_identifier";
    const PARAMETER_LANGUAGE = "language_indicator";
    const PARAMETER_TRANSACTION_TOKEN = "transaction_token";
    const PARAMETER_TRANSACTION_ID = "transaction_id";
    const PARAMETER_CURRENCY_CODE = "currency_code";
    const PARAMETER_TRANSACTION_AMOUNT = "transaction_amount";
    const PARAMETER_DO_NOT_EXIST = "Parameter do not exist";
    const PARAMETER_CARD = "card";
    const PARAMETER_CARD_NAME = "name";
    const PARAMETER_CARD_NUMBER = "number";
    const PARAMETER_CARD_EXP_MONTH = "exp_month";
    const PARAMETER_CARD_EXP_YEAR = "exp_year";
    const PARAMETER_CARD_CVC = "cvc";
    const PARAMETER_DEFERRED = "deferred";
    const PARAMETER_MONTHS = "months";
    const PARAMETER_ERRORS = "error";
    const PARAMETER_ERRORS_MESSAGE = "message";
    const PARAMETER_ERRORS_CODE = "code";

    const CONTENT_TYPE = "application/json";
    const KUSHKI_PUBLIC_KEY = "-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAtCBqxKQo4DgvZLk5CMDFqgRdCrW10GBc
bcrh5b3jicGzU4PIoNEx/g4YNmj5jD6/BEYkHp6aAXMUtn/MWzd+P+dIUvckvf4hn9IMV1gtBYkf
bVcfcB37Q65eTYNCkjryWpxW4TMJ5cbjD9t0ywTU5txBdQBRYxyp7YXu+EGPpk1u1rcYhJu+27xA
+VKqEi5VxL73qA//EBQRdFYoqhWwNVLeKenyoQo8OtoF7wMgM+BSK0kVsvFQP6/OJpnlGPxTOIws
34Yw50TYe15w+ueGLEtQmmFAHPFkEyGTXhczBoOr2obPuJmno3JKPGBs48xXckazyotRC7B4ymCJ
I3fvvwIDAQAB
-----END PUBLIC KEY-----";
}

?>
