<?php
namespace kushki\tests\unit\lib;

use kushki\lib\KushkiResponse;
use kushki\lib\KushkiConstant;
use kushki\tests\lib\CommonUtils;

class ResponseBuilder {

    static public function createChargeOKResponse() {
        $randomTransactionId = CommonUtils::randomAlphaNumberString(15, 40);
        $body = array(KushkiConstant::PARAMETER_TRANSACTION_ID => $randomTransactionId);
        $jsonBody = json_encode($body);
        $response = new KushkiResponse(KushkiConstant::CONTENT_TYPE, $jsonBody, 200);
        return $response;
    }

    static public function createChargeFailedResponse() {
        $randomErrorMessage = CommonUtils::randomAlphaNumberString(15, 40);

        $body = array(KushkiConstant::PARAMETER_ERRORS =>
                          array(KushkiConstant::PARAMETER_ERRORS_MESSAGE =>
                                    $randomErrorMessage),
                      KushkiConstant::PARAMETER_ERRORS_CODE => rand(1, 10));
        $jsonBody = json_encode($body);
        $response = new KushkiResponse(KushkiConstant::CONTENT_TYPE, $jsonBody, 402);
        return $response;
    }

}
