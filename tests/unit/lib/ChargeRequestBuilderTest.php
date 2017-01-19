<?php
namespace kushki\tests\unit\lib;

use kushki\lib\ChargeRequestBuilder;
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

    private function createChargeRequest($withTax = false) {
        $this->environment = CommonUtils::randomAlphaNumberString();
        $this->randomMerchantId = CommonUtils::randomAlphaNumberString();
        $this->randomTransactionToken = CommonUtils::randomAlphaNumberString();
        if(!$withTax) {
            $this->randomTransactionAmount = CommonUtils::getRandomAmount();
        } else {
            $this->randomTransactionAmount = CommonUtils::getRandomAmountColombia();
        }

        $builder = new ChargeRequestBuilder($this->randomMerchantId, $this->randomTransactionToken,
                                            $this->randomTransactionAmount, $this->environment);
        $this->request = $builder->createRequest();
    }

    public function testHasAppropiateUrlAccordingToTheEnvironment() {
        $this->createChargeRequest();
        $this->assertEquals($this->environment . KushkiConstant::CHARGE_URL, $this->request->getUrl(),
                            "Environment URL is not set correctly");
    }

    public function testHasAppropiateUrlAccordingToTheEnvironmentColombia() {
        $this->createChargeRequest(true);
        $this->assertEquals($this->environment . KushkiConstant::CHARGE_URL, $this->request->getUrl(),
            "Environment URL is not set correctly");
    }

    public function testHasContentTypeOnChargeRequest() {
        $this->createChargeRequest();
        $this->assertEquals(KushkiConstant::CONTENT_TYPE, $this->request->getContentType(),
            "Requires content type");
    }

    public function testHasContentTypeOnChargeRequestColombia() {
        $this->createChargeRequest(true);
        $this->assertEquals(KushkiConstant::CONTENT_TYPE, $this->request->getContentType(),
                            "Requires content type");
    }

    public function testHasTokenOnChargeRequest() {
        $this->createChargeRequest();
        $this->assertEquals($this->randomTransactionToken,
                            $this->request->getParameter(KushkiConstant::PARAMETER_TRANSACTION_TOKEN),
                            "Requires param token");
    }

    public function testHasTokenOnChargeRequestColombia() {
        $this->createChargeRequest(true);
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

    public function testHasAmountOnChargeRequestColombia() {
        $this->createChargeRequest(true);
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

    public function testHasCurrencyOnChargeRequestColombia() {
        $this->createChargeRequest(true);
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

    public function testHasMerchantIdOnChargeRequestColombia() {
        $this->createChargeRequest(true);
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

    public function testThrowExceptionOnIncorrectParameterColombia() {
        $this->createChargeRequest(true);

        $this->setExpectedException(
            'kushki\lib\KushkiException', 'Parameter does not exist', 0
        );
        $this->request->getParameter(CommonUtils::randomAlphaString());
    }
}
