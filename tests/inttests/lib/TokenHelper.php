<?php
namespace kushki\tests\inttests\lib;
use kushki\lib\KushkiConstant;

/**
 * Created by IntelliJ IDEA.
 * User: lmunda
 * Date: 19/04/16
 * Time: 17:13
 */
require_once dirname(__FILE__) . '/TokenRequestBuilder.php';
require_once dirname(__FILE__) . '/TokenRequestHandler.php';
class TokenHelper {

    public static function getValidTokenTransaction($merchantId) {
        $cardParams = array(
            KushkiConstant::PARAMETER_CARD_NAME => "John Doe",
            KushkiConstant::PARAMETER_CARD_NUMBER => "4017779991118888",
            KushkiConstant::PARAMETER_CARD_EXP_MONTH => "12",
            KushkiConstant::PARAMETER_CARD_EXP_YEAR => "21",
            KushkiConstant::PARAMETER_CARD_CVC => "123",
        );
        return self::requestToken($merchantId, $cardParams);
    }

    public static function requestToken($merchantId, $cardParams) {
        $tokenRequestBuilder = new TokenRequestBuilder($merchantId, $cardParams);
        $request = $tokenRequestBuilder->createRequest();

        $requestHandler = new TokenRequestHandler($request);

        return $requestHandler->requestToken();
    }
}