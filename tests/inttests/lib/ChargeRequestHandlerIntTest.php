<?php
namespace kushki\tests\unit\lib;

use kushki\lib\HttpHandler;
use kushki\lib\ChargeRequestHandler;
use kushki\lib\KushkiConstant;
use kushki\lib\KushkiCurrencies;
use kushki\lib\KushkiLanguages;
use kushki\lib\RequestBuilder;

class ChargeRequestHandlerIntTest extends \PHPUnit_Framework_TestCase
{

    public function testMustGet200ResponseCodeWhenChargeBeOk()
    {
        $successToken = "d0099d11-f443-4e54-b7aa-6ede163c94c9";
        $request = $this->createRequest($successToken);
        $requestHandler = new ChargeRequestHandler($request);
        $response = $requestHandler->charge();
        $this->assertEquals(true, $response->isSuccessful());
    }

    public function testMustGet402ResponseCodeWhenChargeBeDeclined()
    {
        $declinedToken = "123456789-declined";
        $request = $this->createRequest($declinedToken);
        $requestHandler = new ChargeRequestHandler($request);

        $response = $requestHandler->charge();
        $this->assertEquals(false, $response->isSuccessful());
    }

    private function createRequest($token)
    {
        $amount = rand(1, 1000);
        $currency = KushkiCurrencies::USD;
        $merchantId = "MERCHANT-PRIVATE-ID";
        $builder = new RequestBuilder();
        $builder->setUrl(KushkiConstant::CHARGE_URL);
        $builder->setToken($token);
        $builder->setAmount($amount);
        $builder->setCurrency($currency);
        $builder->setMerchantId($merchantId);
        $builder->setLanguage(KushkiLanguages::ES);

        $request = $builder->createChargeRequest();
        return $request;
    }


}
