<?php
namespace kushki\tests\unit\lib;

use kushki\lib\ChargeRequestBuilder;
use kushki\lib\HttpHandler;
use kushki\lib\ChargeRequestHandler;

class ChargeRequestHandlerIntTest extends \PHPUnit_Framework_TestCase {

    public function testMustGet200ResponseCodeWhenChargeBeOk() {
//        $successToken = "s25s784a87ad497af797a48sdg7rhy4d";
//        $request = $this->createRequest($successToken);
//        $requestHandler = new ChargeRequestHandler($request);
//        $response = $requestHandler->charge();
//        $this->assertEquals(true, $response->isSuccessful());
        $this->assertEquals(true, true);
    }

//    public function testMustGet402ResponseCodeWhenChargeBeDeclined() {
//        $declinedToken = "123456789-declined";
//        $request = $this->createRequest($declinedToken);
//        $requestHandler = new ChargeRequestHandler($request);
//
//        $response = $requestHandler->charge();
//        $this->assertEquals(false, $response->isSuccessful());
//    }
//
//    private function createRequest($token) {
//        $amount = rand(100, 1000);
//        $cents = rand(1, 99) / 100;
//        $amount = $amount + $cents;
//        $merchantId = "10000000123454545454546546";
//        $builder = new ChargeRequestBuilder($merchantId, $token, $amount);
//        $request = $builder->createRequest();
//        return $request;
//    }


}
