<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 3/21/17
 * Time: 10:50 AM
 */

namespace kushki\tests\unit\lib;

use kushki\lib\KushkiSubscriptionUpdateRequest;
use kushki\lib\KushkiCurrency;
use kushki\tests\lib\CommonUtils;
use PHPUnit_Framework_TestCase;

class KushkiSubscriptionUpdateRequestTest  extends PHPUnit_Framework_TestCase{
    private $environment;
    private $randomMerchantId;
    private $periodicity;
    private $subscriptionId;
    private $body;
    private $request;

    public function testHasMerchantIdOnUpdateRequest() {
        $this->createSubscriptionUpdateRequest();
        $this->assertEquals($this->randomMerchantId,
            $this->request->getParameter("private-merchant-id"),
            "Requires param private-merchant-id");
    }

    public function testHasSubscriptionIdOnUpdateRequest() {
        $this->createSubscriptionUpdateRequest();
        $this->assertEquals($this->subscriptionId,
            $this->request->getParameter("subscriptionId"),
            "Requires param subscriptionId");
    }

    public function testHasBodyOnUpdateRequest() {
        $this->createSubscriptionUpdateRequest();
        $this->assertEquals($this->body,
            $this->request->getParameter("body"),
            "Requires param body");
    }

    private function createSubscriptionUpdateRequest() {
        $this->environment = CommonUtils::randomAlphaNumberString();
        $this->randomMerchantId = CommonUtils::randomAlphaNumberString();
        $this->periodicity = CommonUtils::randomAlphaNumberString();
        $this->subscriptionId = CommonUtils::randomAlphaNumberString();
        $this->body = array("periodicity" => $this->periodicity);
        $this->request = new KushkiSubscriptionUpdateRequest($this->randomMerchantId,$this->subscriptionId,
            $this->body, $this->environment);
    }
}