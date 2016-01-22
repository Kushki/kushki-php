<?php
namespace kushki\tests\unit\lib;

use PHPUnit_Framework_TestCase;

require_once('ResponseBuilder.php');

class DeferredChargeRequestHandlerTest extends PHPUnit_Framework_TestCase {

    public function testMustGet200ResponseCode() {
        $responseExpected = ResponseBuilder::createChargeOKResponse();
        $chargeHandlerMock = $this->prepareMock($responseExpected);

        $response = $chargeHandlerMock->deferredCharge();
        $this->assertEquals(200, $response->getCode());
    }

    public function testMustGet402ResponseCode() {
        $responseExpected = ResponseBuilder::createChargeFailedResponse();
        $ChargeHandlerMock = $this->prepareMock($responseExpected);

        $response = $ChargeHandlerMock->deferredCharge();
        $this->assertEquals(402, $response->getCode());
    }

    private function prepareMock($responseExpected) {
        $mock = $this->getMockBuilder('DeferredChargeRequestHandler')
                     ->enableProxyingToOriginalMethods()
                     ->setMethods(array('call', 'deferredCharge'))
                     ->getMock();

        $mock->method('deferredCharge')->willReturn($responseExpected);

        return $mock;
    }
}
