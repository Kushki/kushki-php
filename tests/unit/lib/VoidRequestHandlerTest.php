<?php
namespace kushki\tests\unit\lib;

use PHPUnit_Framework_TestCase;

require_once('ResponseBuilder.php');

class VoidRequestHandlerTest extends PHPUnit_Framework_TestCase {

    public function testMustGet200ResponseCode() {
        $responseExpected = ResponseBuilder::createChargeOKResponse();
        $chargeHandlerMock = $this->prepareMock($responseExpected);

        $response = $chargeHandlerMock->voidCharge();
        $this->assertEquals(200, $response->getCode());
    }

    public function testMustGet402ResponseCode() {
        $responseExpected = ResponseBuilder::createChargeFailedResponse();
        $ChargeHandlerMock = $this->prepareMock($responseExpected);

        $response = $ChargeHandlerMock->voidCharge();
        $this->assertEquals(402, $response->getCode());
    }

    private function prepareMock($responseExpected) {
        $mock = $this->getMockBuilder('VoidRequestHandler')
                     ->enableProxyingToOriginalMethods()
                     ->setMethods(array('call', 'voidCharge'))
                     ->getMock();

        $mock->method('voidCharge')->willReturn($responseExpected);

        return $mock;
    }
}
