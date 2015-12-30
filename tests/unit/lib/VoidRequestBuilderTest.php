<?php
namespace kushki\tests\unit\lib;

use kushki\lib\KushkiConstant;
use kushki\lib\KushkiCurrencies;
use kushki\lib\VoidRequestBuilder;
use kushki\tests\lib\CommonUtils;
use PHPUnit_Framework_TestCase;

class VoidRequestBuilderTest extends PHPUnit_Framework_TestCase {

    private $request;
    private $randomUrl;
    private $randomMerchantId;
    private $currency = KushkiCurrencies::USD;
    private $randomTransactionAmount;
    private $randomTransactionToken;
    private $randomTransactionTicket;

    private function createChargeRequest() {
        $this->randomUrl = CommonUtils::randomAlphaNumberString();
        $this->randomMerchantId = CommonUtils::randomAlphaNumberString();
        $this->randomTransactionToken = CommonUtils::randomAlphaNumberString();
        $this->randomTransactionTicket = CommonUtils::randomAlphaNumberString();
        $this->randomTransactionAmount = rand(1, 9999);

        $builder = new VoidRequestBuilder($this->randomMerchantId,
                                          $this->randomTransactionToken,
                                          $this->randomTransactionTicket,
                                          $this->randomTransactionAmount);
        $this->request = $builder->createRequest();
    }

    public function testHasContentTypeOnVoidRequest() {
        $this->createChargeRequest();
        $this->assertEquals(KushkiConstant::CONTENT_TYPE, $this->request->getContentType(),
                            "Requires content type");
    }

    public function testHasTokenOnVoidRequest() {
        $this->createChargeRequest();
        $this->assertEquals($this->randomTransactionToken,
                            $this->request->getParameter(KushkiConstant::PARAMETER_TRANSACTION_TOKEN),
                            "Requires param token");
    }

    public function testHasTicketOnVoidRequest() {
        $this->createChargeRequest();
        $this->assertEquals($this->randomTransactionTicket,
                            $this->request->getParameter(KushkiConstant::PARAMETER_TRANSACTION_TICKET),
                            "Requires param token");
    }

    public function testHasAmountOnVoidRequest() {
        $this->createChargeRequest();
        $this->assertEquals($this->randomTransactionAmount,
                            $this->request->getParameter(KushkiConstant::PARAMETER_TRANSACTION_AMOUNT),
                            "Requires param amount");
    }

    public function testHasCurrencyOnVoidRequest() {
        $this->createChargeRequest();
        $this->assertEquals($this->currency,
                            $this->request->getParameter(KushkiConstant::PARAMETER_CURRENCY_CODE),
                            "Requires param currency");
    }

    public function testHasMerchantIdOnVoidRequest() {
        $this->createChargeRequest();
        $this->assertEquals($this->randomMerchantId,
                            $this->request->getParameter(KushkiConstant::PARAMETER_MERCHANT_ID),
                            "Requires param merchant_id on void request");
    }

    public function testThrowExceptionOnIncorrectParameter() {
        $this->createChargeRequest();

        $this->setExpectedException(
            'kushki\lib\KushkiException', 'Parameter does not exist', 0
        );
        $this->request->getParameter(CommonUtils::randomAlphaString());
    }
}
