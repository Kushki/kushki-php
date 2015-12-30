<?php
namespace kushki\tests\unit\lib;

use PHPUnit_Framework_TestCase;

require_once('ResponseBuilder.php');

class TokenRequestHandlerTest extends PHPUnit_Framework_TestCase {

    public function testMustGet200ResponseCode() {
        $responseExpected = ResponseBuilder::createChargeOKResponse();
        $tokenHandlerMock = $this->prepareMock($responseExpected);

        $response = $tokenHandlerMock->requestToken();
        $this->assertEquals(200, $response->getCode());
    }

    public function testMustGet402ResponseCode() {
        $responseExpected = ResponseBuilder::createChargeFailedResponse();
        $tokenHandlerMock = $this->prepareMock($responseExpected);

        $response = $tokenHandlerMock->requestToken();
        $this->assertEquals(402, $response->getCode());
    }

    private function prepareMock($responseExpected) {
        $mock = $this->getMockBuilder('TokenRequestHandler')
                     ->enableProxyingToOriginalMethods()
                     ->setMethods(array('call', 'requestToken'))
                     ->getMock();

        $mock->method('requestToken')->willReturn($responseExpected);

        return $mock;
    }
}
