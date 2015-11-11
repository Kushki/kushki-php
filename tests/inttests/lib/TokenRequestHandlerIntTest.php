<?php
namespace kushki\tests\unit\lib;

use kushki\lib\CurlHandler;
use kushki\lib\KushkiConstant;
use kushki\lib\TokenRequestHandler;
use kushki\lib\RequestBuilder;

class TokenRequestHandlerIntTest extends \PHPUnit_Framework_TestCase
{

    public function testMustGet200ResponseCodeWhenGetTokenBeOk()
    {
        $CurlHandler = new CurlHandler();
        $requestHandler = new TokenRequestHandler($CurlHandler);
        $successCardNumber = '4242424242424242';
        $request = $this->createRequest($successCardNumber);
        $response = $requestHandler->getToken($request);
        $this->assertEquals(200, $response->getResponseCode());
    }

    public function testMustGetTokenWhenGetTokenBeOk()
    {
        $CurlHandler = new CurlHandler();
        $requestHandler = new TokenRequestHandler($CurlHandler);
        $successCardNumber = '4242424242424242';
        $request = $this->createRequest($successCardNumber);
        $response = $requestHandler->getToken($request);
        $responseObject = json_decode($response->getBody());
        $this->assertObjectHasAttribute(KushkiConstant::PARAMETER_TRANSACTION_TOKEN, $responseObject);
    }

    public function testMustGet402ResponseCodeWhenGetTokenBeDeclined()
    {
        $CurlHandler = new CurlHandler();
        $requestHandler = new TokenRequestHandler($CurlHandler);
        $declinedCardNumber = '4000000000000002';
        $request = $this->createRequest($declinedCardNumber);

        $response = $requestHandler->getToken($request);
        $this->assertEquals(402, $response->getResponseCode());
    }

    public function testMustGetErrorMessageWhenGetTokenBeDeclined()
    {
        $CurlHandler = new CurlHandler();
        $requestHandler = new TokenRequestHandler($CurlHandler);
        $declinedCardNumber = '4000000000000002';
        $request = $this->createRequest($declinedCardNumber);

        $response = $requestHandler->getToken($request);
        $responseObject = json_decode($response->getBody());
        $this->assertObjectHasAttribute('error', $responseObject);
        $this->assertObjectHasAttribute('message', $responseObject->error);
    }

    private function createRequest($cardNumber)
    {
        $cardName = Utils::randomAlphaString(10, 60);
        $expiredMonth = '01';
        $expiredYear = rand(20, 99);
        $cvc = rand(100, 999);
        $deferred = true;
        $months = 3;
        $merchantId = "MERCHANT-PUBLIC-ID";
        $request = RequestBuilder::createTokenRequest(KushkiConstant::GET_TOKEN_URL,
            $merchantId, $cardName,
            $cardNumber, $expiredMonth,
            $expiredYear, $cvc,
            $deferred, $months);
        return $request;
    }


}
