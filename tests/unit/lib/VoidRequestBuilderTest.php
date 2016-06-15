<?php
namespace kushki\tests\unit\lib;

use kushki\lib\KushkiConstant;
use kushki\lib\KushkiCurrency;
use kushki\lib\VoidRequestBuilder;
use kushki\tests\lib\CommonUtils;
use PHPUnit_Framework_TestCase;

require_once dirname(__FILE__) . '/../../lib/CommonUtils.php';

class VoidRequestBuilderTest extends PHPUnit_Framework_TestCase {

    private $request;
    private $environment;
    private $randomMerchantId;
    private $currency = KushkiCurrency::USD;
    private $randomTransactionAmount;
    private $randomTransactionTicket;

    private function createVoidRequest() {
        $this->environment = CommonUtils::randomAlphaNumberString();
        $this->randomMerchantId = CommonUtils::randomAlphaNumberString();
        $this->randomTransactionTicket = CommonUtils::randomAlphaNumberString();
        $this->randomTransactionAmount = CommonUtils::getRandomAmount();

        $builder = new VoidRequestBuilder($this->randomMerchantId, $this->randomTransactionTicket,
                                          $this->randomTransactionAmount, $this->environment);
        $this->request = $builder->createRequest();
    }

    public function testHasAppropiateUrlAccordingToTheEnvironment() {
        $this->createVoidRequest();
        $this->assertEquals($this->environment . KushkiConstant::VOID_URL, $this->request->getUrl(),
                            "Environment URL is not set correctly");
    }

    public function testHasContentTypeOnVoidRequest() {
        $this->createVoidRequest();
        $this->assertEquals(KushkiConstant::CONTENT_TYPE, $this->request->getContentType(),
                            "Requires content type");
    }

    public function testHasTicketOnVoidRequest() {
        $this->createVoidRequest();
        $this->assertEquals($this->randomTransactionTicket,
                            $this->request->getParameter(KushkiConstant::PARAMETER_TRANSACTION_TICKET),
                            "Requires param token");
    }

    public function testHasAmountOnVoidRequest() {
        $this->createVoidRequest();
        $this->assertEquals($this->randomTransactionAmount->toHash(),
                            $this->request->getParameter(KushkiConstant::PARAMETER_TRANSACTION_AMOUNT),
                            "Requires param amount");
    }

    public function testHasCurrencyOnVoidRequest() {
        $this->createVoidRequest();
        $this->assertEquals($this->currency,
                            $this->request->getParameter(KushkiConstant::PARAMETER_CURRENCY_CODE),
                            "Requires param currency");
    }

    public function testHasMerchantIdOnVoidRequest() {
        $this->createVoidRequest();
        $this->assertEquals($this->randomMerchantId,
                            $this->request->getParameter(KushkiConstant::PARAMETER_MERCHANT_ID),
                            "Requires param merchant_id on void request");
    }

    public function testThrowExceptionOnIncorrectParameter() {
        $this->createVoidRequest();

        $this->setExpectedException(
            'kushki\lib\KushkiException', 'Parameter does not exist', 0
        );
        $this->request->getParameter(CommonUtils::randomAlphaString());
    }
}
