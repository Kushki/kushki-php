<?php
namespace kushki\tests\unit\lib;

use kushki\lib\KushkiConstant;
use kushki\lib\KushkiCurrencies;
use kushki\lib\RefundRequestBuilder;
use kushki\tests\lib\CommonUtils;
use PHPUnit_Framework_TestCase;

class RefundRequestBuilderTest extends PHPUnit_Framework_TestCase {

    private $request;
    private $randomUrl;
    private $randomMerchantId;
    private $currency = KushkiCurrencies::USD;
    private $randomTransactionAmount;
    private $randomTransactionTicket;

    private function createChargeRequest() {
        $this->randomUrl = CommonUtils::randomAlphaNumberString();
        $this->randomMerchantId = CommonUtils::randomAlphaNumberString();
        $this->randomTransactionTicket = CommonUtils::randomAlphaNumberString();
        $this->randomTransactionAmount = rand(1, 9999);

        $builder = new RefundRequestBuilder($this->randomMerchantId,
                                            $this->randomTransactionTicket,
                                            $this->randomTransactionAmount);
        $this->request = $builder->createRequest();
    }

    public function testHasContentTypeOnRefundRequest() {
        $this->createChargeRequest();
        $this->assertEquals(KushkiConstant::CONTENT_TYPE, $this->request->getContentType(),
                            "Requires content type");
    }

    public function testHasTicketOnRefundRequest() {
        $this->createChargeRequest();
        $this->assertEquals($this->randomTransactionTicket,
                            $this->request->getParameter(KushkiConstant::PARAMETER_TRANSACTION_TICKET),
                            "Requires param token");
    }

    public function testHasAmountOnRefundRequest() {
        $this->createChargeRequest();
        $this->assertEquals($this->randomTransactionAmount,
                            $this->request->getParameter(KushkiConstant::PARAMETER_TRANSACTION_AMOUNT),
                            "Requires param amount");
    }

    public function testHasCurrencyOnRefundRequest() {
        $this->createChargeRequest();
        $this->assertEquals($this->currency,
                            $this->request->getParameter(KushkiConstant::PARAMETER_CURRENCY_CODE),
                            "Requires param currency");
    }

    public function testHasMerchantIdOnRefundRequest() {
        $this->createChargeRequest();
        $this->assertEquals($this->randomMerchantId,
                            $this->request->getParameter(KushkiConstant::PARAMETER_MERCHANT_ID),
                            "Requires param merchant_id on refund request");
    }

    public function testThrowExceptionOnIncorrectParameter() {
        $this->createChargeRequest();

        $this->setExpectedException(
            'kushki\lib\KushkiException', 'Parameter does not exist', 0
        );
        $this->request->getParameter(CommonUtils::randomAlphaString());
    }
}
