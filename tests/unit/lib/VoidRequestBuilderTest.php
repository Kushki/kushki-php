<?php
namespace kushki\tests\unit\lib;

use kushki\lib\KushkiConstant;
use kushki\lib\KushkiCurrency;
use kushki\lib\KushkiVoidRequest;
use kushki\lib\VoidRequestBuilder;
use kushki\tests\lib\CommonUtils;
use PHPUnit_Framework_TestCase;

require_once dirname(__FILE__) . '/../../lib/CommonUtils.php';

class VoidRequestBuilderTest extends PHPUnit_Framework_TestCase {

    private $request;
    private $environment;
    private $randomMerchantId;
    private $randomTransactionAmount;
    private $randomTransactionTicket;

    public function testHasTicketOnVoidRequest() {
        $this->createVoidRequest();
        $this->assertEquals($this->randomTransactionTicket,
                            $this->request->getParameter("ticketNumber"),
                            "Requires param ticketNumber");
    }

    public function testHasMerchantIdOnVoidRequest() {
        $this->createVoidRequest();
        $this->assertEquals($this->randomMerchantId,
                            $this->request->getParameter("private-merchant-id"),
                            "Requires param merchant_id on void request");
    }

    public function testThrowExceptionOnIncorrectParameter() {
        $this->createVoidRequest();

        $this->setExpectedException(
            'kushki\lib\KushkiException', 'Parameter does not exist', 0
        );
        $this->request->getParameter(CommonUtils::randomAlphaString());
    }

    private function createVoidRequest($isColombianTransaction = false) {
        $this->environment = CommonUtils::randomAlphaNumberString();
        $this->randomMerchantId = CommonUtils::randomAlphaNumberString();
        $this->randomTransactionTicket = CommonUtils::randomAlphaNumberString();
        if($isColombianTransaction) {
            $this->randomTransactionAmount = CommonUtils::getRandomAmountColombia();
        } else {
            $this->randomTransactionAmount = CommonUtils::getRandomAmount();
        }
        $this->request = new KushkiVoidRequest($this->randomMerchantId, $this->randomTransactionTicket,
            $this->randomTransactionAmount, $this->environment);
    }
}
