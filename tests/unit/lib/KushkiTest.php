<?php
namespace kushki\tests\unit\lib;

use kushki\lib\Amount;
use kushki\lib\KushkiCurrency;
use kushki\lib\KushkiLanguage;
use kushki\lib\Kushki;
use kushki\lib\RequestHandler;
use kushki\tests\lib\CommonUtils;
use PHPUnit_Framework_TestCase;
use ReflectionProperty;
use kushki\lib\Tax;

class KushkiTest extends PHPUnit_Framework_TestCase {
    private $environment;
    private $kushki;
    private $merchantId;
    private $requestHandler;
    private $actionUrl;

    protected function setUp() {
        $this->environment = CommonUtils::randomAlphaString(5, 10);
        $this->merchantId = rand(1000, 10000);
        $this->kushki = new Kushki($this->merchantId, KushkiLanguage::ES, KushkiCurrency::USD, $this->environment);
        $this->requestHandler = $this->getMockBuilder(RequestHandler::class)
                                     ->setMethods(array('call'))
                                     ->getMock();
        $this->overrideRequestHandler($this->kushki, $this->requestHandler);
    }

    public function testHasMerchantId() {
        $this->assertEquals($this->merchantId, $this->kushki->getMerchantId(), "Does not have merchant id");
    }

    public function testChargeHasCorrectUrl() {
        $this->actionUrl = '/charge';
        $this->assertUrl();
        $this->kushki->charge("a", new Amount(1, 1, 1, 1));
    }

    public function testChargeHasCorrectUrlColombia() {
        $this->actionUrl = '/charge';
        $this->assertUrl();
        $tax = new Tax(1, 1, 1, 1);
        $this->kushki->charge("a", new Amount(1, 1, 1, $tax));
    }

    public function testDeferredChargeHasCorrectUrl() {
        $this->actionUrl = '/deferred';
        $this->assertUrl();
        $this->kushki->deferredCharge("a", new Amount(1, 1, 1, 1), 3);
    }

    public function testDeferredChargeHasCorrectUrlColombia() {
        $this->actionUrl = '/deferred';
        $this->assertUrl();
        $tax = new Tax(1, 1, 1, 1);
        $this->kushki->deferredCharge("a", new Amount(1, 1, 1, $tax), 3);
    }

    public function testVoidHasCorrectUrl() {
        $this->actionUrl = '/void';
        $this->assertUrl();
        $this->kushki->voidCharge("a", new Amount(1, 1, 1, 1));
    }

    public function testVoidHasCorrectUrlColombia() {
        $this->actionUrl = '/void';
        $this->assertUrl();
        $tax = new Tax(1, 1, 1, 1);
        $this->kushki->voidCharge("a", new Amount(1, 1, 1, $tax));
    }

    private function overrideRequestHandler($kushki, $requestHandler) {
        $requestHandlerProperty = new ReflectionProperty(Kushki::class, 'requestHandler');
        $requestHandlerProperty->setAccessible(true);
        $requestHandlerProperty->setValue($kushki, $requestHandler);
    }

    private function assertUrl() {
        $this->requestHandler->expects($this->once())
                             ->method('call')
                             ->will($this->returnCallback(function ($request) {
                                 $this->assertEquals($this->environment . $this->actionUrl, $request->getUrl());
                             }));
    }
}
