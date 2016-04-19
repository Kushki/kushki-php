<?php
namespace kushki\tests\unit\lib;

use kushki\lib\ChargeRequestBuilder;
use kushki\lib\KushkiConstant;
use kushki\lib\KushkiCurrencies;
use kushki\tests\lib\CommonUtils;
use PHPUnit_Framework_TestCase;

require_once dirname(__FILE__) . '/../../lib/CommonUtils.php';

class ChargeRequestBuilderTest extends PHPUnit_Framework_TestCase {

    private $request;
    private $randomUrl;
    private $randomMerchantId;
    private $currency = KushkiCurrencies::USD;
    private $randomTransactionAmount;
    private $randomTransactionToken;

    private function createChargeRequest() {
        $this->randomUrl = CommonUtils::randomAlphaNumberString();
        $this->randomMerchantId = CommonUtils::randomAlphaNumberString();
        $this->randomTransactionToken = CommonUtils::randomAlphaNumberString();
        $this->randomTransactionAmount = CommonUtils::getRandomAmount();

        $builder = new ChargeRequestBuilder($this->randomMerchantId,
                                            $this->randomTransactionToken,
                                            $this->randomTransactionAmount);
        $this->request = $builder->createRequest();
    }

    public function testHasContentTypeOnChargeRequest() {
        $this->createChargeRequest();
        $this->assertEquals(KushkiConstant::CONTENT_TYPE, $this->request->getContentType(),
                            "Requires content type");
    }

    public function testHasTokenOnChargeRequest() {
        $this->createChargeRequest();
        $this->assertEquals($this->randomTransactionToken,
                            $this->request->getParameter(KushkiConstant::PARAMETER_TRANSACTION_TOKEN),
                            "Requires param token");
    }

    public function testHasAmountOnChargeRequest() {
        $this->createChargeRequest();
        $this->assertEquals($this->randomTransactionAmount->toHash(),
                            $this->request->getParameter(KushkiConstant::PARAMETER_TRANSACTION_AMOUNT),
                            "Requires param amount");
    }

    public function testHasCurrencyOnChargeRequest() {
        $this->createChargeRequest();
        $this->assertEquals($this->currency,
                            $this->request->getParameter(KushkiConstant::PARAMETER_CURRENCY_CODE),
                            "Requires param currency");
    }

    public function testHasMerchantIdOnChargeRequest() {
        $this->createChargeRequest();
        $this->assertEquals($this->randomMerchantId,
                            $this->request->getParameter(KushkiConstant::PARAMETER_MERCHANT_ID),
                            "Requires param merchant_id on charge request");
    }

    public function testThrowExceptionOnIncorrectParameter() {
        $this->createChargeRequest();

        $this->setExpectedException(
            'kushki\lib\KushkiException', 'Parameter does not exist', 0
        );
        $this->request->getParameter(CommonUtils::randomAlphaString());
    }
}
