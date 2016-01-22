<?php
namespace kushki\tests\unit\lib;

use kushki\lib\ChargeRequestBuilder;
use kushki\lib\DeferredChargeRequestBuilder;
use kushki\lib\KushkiConstant;
use kushki\lib\KushkiCurrencies;
use kushki\tests\lib\CommonUtils;
use PHPUnit_Framework_TestCase;

class DeferredChargeRequestBuilderTest extends PHPUnit_Framework_TestCase {

    private $request;
    private $randomUrl;
    private $randomMerchantId;
    private $currency = KushkiCurrencies::USD;
    private $randomTransactionAmount;
    private $randomTransactionToken;
    private $randomMonths;
    private $randomInterest;

    private function createDeferredChargeRequest() {
        $this->randomUrl = CommonUtils::randomAlphaNumberString();
        $this->randomMerchantId = CommonUtils::randomAlphaNumberString();
        $this->randomTransactionToken = CommonUtils::randomAlphaNumberString();
        $this->randomTransactionAmount = rand(1, 9999);
        $this->randomMonths = rand(1, 24);
        $this->randomInterest = rand(1, 10) / 100;

        $builder = new DeferredChargeRequestBuilder($this->randomMerchantId,
                                                    $this->randomTransactionToken,
                                                    $this->randomTransactionAmount,
                                                    $this->randomMonths,
                                                    $this->randomInterest);
        $this->request = $builder->createRequest();
    }

    public function testHasContentTypeOnDeferredChargeRequest() {
        $this->createDeferredChargeRequest();
        $this->assertEquals(KushkiConstant::CONTENT_TYPE, $this->request->getContentType(),
                            "Requires content type");
    }

    public function testHasTokenOnDeferredChargeRequest() {
        $this->createDeferredChargeRequest();
        $this->assertEquals($this->randomTransactionToken,
                            $this->request->getParameter(KushkiConstant::PARAMETER_TRANSACTION_TOKEN),
                            "Requires param token");
    }

    public function testHasAmountOnDeferredChargeRequest() {
        $this->createDeferredChargeRequest();
        $this->assertEquals($this->randomTransactionAmount,
                            $this->request->getParameter(KushkiConstant::PARAMETER_TRANSACTION_AMOUNT),
                            "Requires param amount");
    }

    public function testHasMonthsOnDeferredChargeRequest() {
        $this->createDeferredChargeRequest();
        $this->assertEquals($this->randomMonths,
                            $this->request->getParameter(KushkiConstant::PARAMETER_MONTHS),
                            "Requires param months");
    }

    public function testHasRateOfInterestOnDeferredChargeRequest() {
        $this->createDeferredChargeRequest();
        $this->assertEquals($this->randomInterest,
                            $this->request->getParameter(KushkiConstant::PARAMETER_INTEREST),
                            "Requires param interest");
    }

    public function testHasCurrencyOnDeferredChargeRequest() {
        $this->createDeferredChargeRequest();
        $this->assertEquals($this->currency,
                            $this->request->getParameter(KushkiConstant::PARAMETER_CURRENCY_CODE),
                            "Requires param currency");
    }

    public function testHasMerchantIdOnDeferredChargeRequest() {
        $this->createDeferredChargeRequest();
        $this->assertEquals($this->randomMerchantId,
                            $this->request->getParameter(KushkiConstant::PARAMETER_MERCHANT_ID),
                            "Requires param merchant_id on charge request");
    }

    public function testThrowExceptionOnIncorrectParameter() {
        $this->createDeferredChargeRequest();

        $this->setExpectedException(
            'kushki\lib\KushkiException', 'Parameter does not exist', 0
        );
        $this->request->getParameter(CommonUtils::randomAlphaString());
    }
}
