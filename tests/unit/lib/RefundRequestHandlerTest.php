<?php
namespace kushki\tests\unit\lib;

use PHPUnit_Framework_TestCase;

require_once('ResponseBuilder.php');

class RefundRequestHandlerTest extends PHPUnit_Framework_TestCase {

    public function testMustGet200ResponseCode() {
        $responseExpected = ResponseBuilder::createChargeOKResponse();
        $chargeHandlerMock = $this->prepareMock($responseExpected);

        $response = $chargeHandlerMock->refundCharge();
        $this->assertEquals(200, $response->getCode());
    }

    public function testMustGet402ResponseCode() {
        $responseExpected = ResponseBuilder::createChargeFailedResponse();
        $ChargeHandlerMock = $this->prepareMock($responseExpected);

        $response = $ChargeHandlerMock->refundCharge();
        $this->assertEquals(402, $response->getCode());
    }

    private function prepareMock($responseExpected) {
        $mock = $this->getMockBuilder('RefundRequestHandler')
                     ->enableProxyingToOriginalMethods()
                     ->setMethods(array('call', 'refundCharge'))
                     ->getMock();

        $mock->method('refundCharge')->willReturn($responseExpected);

        return $mock;
    }
}
