<?php

namespace kushki\lib;

define('URL', 'https://ping.aurusinc.com/kushki/api/v1');

class KushkiConstant {
    const VERSION = '1.0';
    const TOKENS_URL = URL . "/tokens";
    const CHARGE_URL = URL . "/charge";
    const VOID_URL = URL . "/void";
    const DEFERRED_URL = URL . "/deferred";
    const PARAMETER_MERCHANT_ID = "merchant_identifier";
    const PARAMETER_LANGUAGE = "language_indicator";
    const PARAMETER_TRANSACTION_TOKEN = "transaction_token";
    const PARAMETER_TRANSACTION_TICKET = "ticket_number";
    const PARAMETER_TRANSACTION_ID = "transaction_id";
    const PARAMETER_CURRENCY_CODE = "currency_code";
    const PARAMETER_TRANSACTION_AMOUNT = "transaction_amount";
    const PARAMETER_TICKET_NUMBER = "ticket_number";
    const PARAMETER_DO_NOT_EXIST = "Parameter does not exist";
    const PARAMETER_CARD = "card";
    const PARAMETER_CARD_NAME = "name";
    const PARAMETER_CARD_NUMBER = "number";
    const PARAMETER_CARD_EXP_MONTH = "expiry_month";
    const PARAMETER_CARD_EXP_YEAR = "expiry_year";
    const PARAMETER_CARD_CVC = "cvv";
    const PARAMETER_DEFERRED = "deferred";
    const PARAMETER_MONTHS = "months";
    const PARAMETER_INTEREST = "rate_of_interest";
    const PARAMETER_ERRORS = "error";
    const PARAMETER_ERRORS_MESSAGE = "message";
    const PARAMETER_ERRORS_CODE = "code";

    const CONTENT_TYPE = "application/json";

    const KUSHKI_PUBLIC_KEY = "-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC81t5iu5C0JxYq5/XNPiD5ol3Z
w8rw3LtFIUm7y3m8o8wv5qVnzGh6XwQ8LWypdkbBDKWZZrAUd3lybZOP7/82Nb1/
noYj8ixVRdbnYtbsSAbu9PxjB7a/7LCGKsugLkou74PJDadQweM88kzQOx/kzAyV
bS9gCCVUguHcq2vRRQIDAQAB
-----END PUBLIC KEY-----";
}

?>
