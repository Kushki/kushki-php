<?php

namespace kushki\lib;

class KushkiConstant
{
    const VERSION = '0.0.1';
    const CHARGE_URL = "https://kushki-api.herokuapp.com/v1/charge";
    const GET_TOKEN_URL = "https://kushki-api.herokuapp.com/v1/charge";
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

    const CONTENT_TYPE = "Content-Type: application/json";

}

?>
