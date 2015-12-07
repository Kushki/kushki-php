<?php
namespace kushki\tests\unit\lib;

use PHPUnit_Framework_TestCase;

require_once('Utils.php');
require_once('ResponseBuilder.php');

class ChargeRequestHandlerTest extends PHPUnit_Framework_TestCase
{

    public function testMustGet200ResponseCode()
    {
        $responseExpected = ResponseBuilder::createChargeOKResponse();
        $chargeHandlerMock = $this->prepareMock($responseExpected);

        $response = $chargeHandlerMock->charge();
        $this->assertEquals(200, $response->getResponseCode());
    }

    public function testMustGet402ResponseCode()
    {
        $responseExpected = ResponseBuilder::createChargeFailedResponse();
        $ChargeHandlerMock = $this->prepareMock($responseExpected);

        $response = $ChargeHandlerMock->charge();
        $this->assertEquals(402, $response->getResponseCode());
    }

    private function prepareMock($responseExpected)
    {
        $mock = $this->getMockBuilder('ChargeRequestHandler')
                    ->enableProxyingToOriginalMethods()
                    ->setMethods(array('call', 'charge'))
                    ->getMock();

        $mock->method('charge')->willReturn($responseExpected);

        return $mock;
    }
}
