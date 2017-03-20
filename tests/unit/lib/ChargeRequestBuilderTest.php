<?php
namespace kushki\tests\unit\lib;

use kushki\lib\ChargeRequestBuilder;
use kushki\lib\KushkiClientRequest;
use kushki\lib\KushkiConstant;
use kushki\lib\KushkiCurrency;
use kushki\tests\lib\CommonUtils;
use PHPUnit_Framework_TestCase;

require_once dirname(__FILE__) . '/../../lib/CommonUtils.php';

class ChargeRequestBuilderTest extends PHPUnit_Framework_TestCase {

    private $request;
    private $environment;
    private $randomMerchantId;
    private $currency = KushkiCurrency::USD;
    private $randomTransactionAmount;
    private $randomTransactionToken;

    public function testHasTokenOnChargeRequest() {
        $this->createChargeRequest();
        $this->assertEquals($this->randomTransactionToken,
                            $this->request->getParameter("token"),
                            "Requires param token");
    }

    public function testHasAmountOnChargeRequest() {
        $this->createChargeRequest();
        $amount = $this->randomTransactionAmount->toHash();
        $amount["currency"] = "USD";
        $this->assertEquals($amount,
            $this->request->getParameter("amount"),
            "Requires param amount");
    }

    public function testHasAmountOnChargeRequestColombia() {
        $this->createChargeRequest(true);
        $amount = $this->randomTransactionAmount->toHash();
        $amount["currency"] = "COP";
        $this->assertEquals($amount,
                            $this->request->getParameter("amount"),
                            "Requires param amount");
    }

    private function createChargeRequest($isColombianTransaction = false) {
        $this->environment = CommonUtils::randomAlphaNumberString();
        $this->randomMerchantId = CommonUtils::randomAlphaNumberString();
        $this->randomTransactionToken = CommonUtils::randomAlphaNumberString();
        if($isColombianTransaction) {
            $this->randomTransactionAmount = CommonUtils::getRandomAmountColombia();
            $this->currency = KushkiCurrency::COP;

        } else {
            $this->randomTransactionAmount = CommonUtils::getRandomAmount();
        }
        $this->request = new KushkiClientRequest($this->randomMerchantId, $this->randomTransactionToken,
            $this->randomTransactionAmount,0,$metadata = false, $this->environment,
            $this->currency);
    }
}
