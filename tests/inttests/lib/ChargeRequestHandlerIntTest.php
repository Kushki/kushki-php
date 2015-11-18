<?php
namespace kushki\tests\unit\lib;

use kushki\lib\CurlHandler;
use kushki\lib\ChargeRequestHandler;
use kushki\lib\KushkiConstant;
use kushki\lib\KushkiCurrencies;
use kushki\lib\KushkiLanguages;
use kushki\lib\RequestBuilder;

class ChargeRequestHandlerIntTest extends \PHPUnit_Framework_TestCase
{

    public function testMustGet200ResponseCodeWhenChargeBeOk()
    {
        $CurlHandler = new CurlHandler();
        $requestHandler = new ChargeRequestHandler($CurlHandler);
        $successToken = "d0099d11-f443-4e54-b7aa-6ede163c94c9";
        $request = $this->createRequest($successToken);
        $response = $requestHandler->charge($request);
        $this->assertEquals(200, $response->getResponseCode());
    }

    public function testMustGet402ResponseCodeWhenChargeBeDeclined()
    {
        $CurlHandler = new CurlHandler();
        $requestHandler = new ChargeRequestHandler($CurlHandler);
        $declinedToken = "123456789-declined";
        $request = $this->createRequest($declinedToken);

        $response = $requestHandler->charge($request);
        $this->assertEquals(402, $response->getResponseCode());
    }

    private function createRequest($token)
    {
        $amount = rand(1, 1000);
        $currency = KushkiCurrencies::USD;
        $merchantId = "MERCHANT-PRIVATE-ID";
        $request = RequestBuilder::createChargeRequest(KushkiConstant::CHARGE_URL, $token, $amount, $currency, $merchantId, KushkiLanguages::ES);
        return $request;
    }


}
