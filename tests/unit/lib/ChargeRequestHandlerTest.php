<?php
namespace kushki\tests\unit\lib;

use kushki\lib\ChargeRequestHandler;
use kushki\lib\kushkiEnums;
use kushki\lib\Request;

class ChargeRequestHandlerTest extends \PHPUnit_Framework_TestCase
{

    public function testMustGet200ResponseCode()
    {
        $responseExpected = ResponseBuilder::createChargeOKResponse();
        $curlHandlerMock = $this->prepareMock($responseExpected);
        $dummyRequest = $this->getDummyRequest();
        $chargeRequestHandler = new ChargeRequestHandler($curlHandlerMock);

        $response = $chargeRequestHandler->charge($dummyRequest);
        $this->assertEquals(200, $response->getResponseCode());
    }

    public function testMustGet402ResponseCode()
    {
        $responseExpected = ResponseBuilder::createChargeFailedResponse();
        $curlHandlerMock = $this->prepareMock($responseExpected);
        $dummyRequest = $this->getDummyRequest();
        $chargeRequestHandler = new ChargeRequestHandler($curlHandlerMock);

        $response = $chargeRequestHandler->charge($dummyRequest);
        $this->assertEquals(402, $response->getResponseCode());
    }

    private function prepareMock($responseExpected)
    {
        $mock = $this->getMockBuilder('CurlHandler')->setMethods(array('call'))->getMock();

        $mock->method('call')->willReturn($responseExpected);

        return $mock;
    }

    private function getDummyRequest()
    {
        $randomUrl = Utils::randomAlphaNumberString(30, 80);
        $dummyRequest = new Request($randomUrl, array());
        return $dummyRequest;
    }
}
