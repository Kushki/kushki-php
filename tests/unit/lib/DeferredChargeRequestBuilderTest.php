<?php
namespace kushki\tests\unit\lib;

use kushki\lib\KushkiChargeRequest;
use kushki\lib\KushkiCurrency;
use kushki\tests\lib\CommonUtils;
use PHPUnit_Framework_TestCase;

require_once dirname(__FILE__) . '/../../lib/CommonUtils.php';

class DeferredChargeRequestBuilderTest extends PHPUnit_Framework_TestCase {

    private $request;
    private $environment;
    private $randomMerchantId;
    private $currency = KushkiCurrency::USD;
    private $randomTransactionAmount;
    private $randomTransactionToken;
    private $randomMonths;


    public function testHasMonthsOnDeferredChargeRequest() {
        $this->createDeferredChargeRequest();
        $this->assertEquals($this->randomMonths,
                            $this->request->getParameter("months"),
                            "Requires param months");
    }

    private function createDeferredChargeRequest($isColombianTransaction = false) {
        $this->environment = CommonUtils::randomAlphaNumberString();
        $this->randomMerchantId = CommonUtils::randomAlphaNumberString();
        $this->randomTransactionToken = CommonUtils::randomAlphaNumberString();
        if($isColombianTransaction) {
            $this->currency = KushkiCurrency::COP;
            $this->randomTransactionAmount = CommonUtils::getRandomAmountColombia();
            $this->randomMonths = rand(2, 36);
        } else {
            $this->randomTransactionAmount = CommonUtils::getRandomAmount();
            $this->randomMonths = rand(1, 12);
        }
        $this->request = new KushkiChargeRequest($this->randomMerchantId, $this->randomTransactionToken,
            $this->randomTransactionAmount,$this->randomMonths,$metadata = false, $this->environment,
            $this->currency);
    }
}
