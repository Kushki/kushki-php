<?php
namespace kushki\tests\unit\lib;

use kushki\lib\KushkiConstant;
use kushki\lib\KushkiCurrencies;
use kushki\lib\TokenRequestBuilder;
use kushki\tests\lib\CommonUtils;
use PHPUnit_Framework_TestCase;

require_once dirname(__FILE__) . '/../../lib/CommonUtils.php';

class TokenRequestBuilderTest extends PHPUnit_Framework_TestCase {

    private $currency = KushkiCurrencies::USD;
    private $request;
    private $randomUrl;
    private $randomMerchantId;
    private $randomCardName;
    private $randomCardNumber;
    private $randomCardExpMonth;
    private $randomCardExpYear;
    private $randomCardCvv;

    private function createTokenRequest() {
        $this->randomUrl = CommonUtils::randomAlphaNumberString();
        $this->randomMerchantId = CommonUtils::randomAlphaNumberString();
        $this->randomCardName = CommonUtils::randomAlphaString();
        $this->randomCardNumber = CommonUtils::randomNumberString(16, 16);
        $this->randomCardExpMonth = CommonUtils::randomNumberString(2, 2);
        $this->randomCardExpYear = CommonUtils::randomNumberString(2, 2);
        $this->randomCardCvv = CommonUtils::randomNumberString(3, 3);

        $cardParams = array(
            KushkiConstant::PARAMETER_CARD_NAME => $this->randomCardName,
            KushkiConstant::PARAMETER_CARD_NUMBER => $this->randomCardNumber,
            KushkiConstant::PARAMETER_CARD_EXP_MONTH => $this->randomCardExpMonth,
            KushkiConstant::PARAMETER_CARD_EXP_YEAR => $this->randomCardExpYear,
            KushkiConstant::PARAMETER_CARD_CVC => $this->randomCardCvv
        );

        $builder = new TokenRequestBuilder($this->randomMerchantId, $cardParams);
        $this->request = $builder->createRequest();
    }

    public function testHasContentTypeOnChargeRequest() {
        $this->createTokenRequest();
        $this->assertEquals(KushkiConstant::CONTENT_TYPE, $this->request->getContentType(),
                            "Requires content type");
    }

    public function testHasCurrencyOnChargeRequest() {
        $this->createTokenRequest();
        $this->assertEquals($this->currency,
                            $this->request->getParameter(KushkiConstant::PARAMETER_CURRENCY_CODE),
                            "Requires param currency");
    }

    public function testHasMerchantIdOnChargeRequest() {
        $this->createTokenRequest();
        $this->assertEquals($this->randomMerchantId,
                            $this->request->getParameter(KushkiConstant::PARAMETER_MERCHANT_ID),
                            "Requires param merchant_id on token request");
    }

    public function testHasCardNameOnChargeRequest() {
        $this->createTokenRequest();
        $cardParam = $this->request->getParameter(KushkiConstant::PARAMETER_CARD);
        $this->assertEquals($this->randomCardName,
                            $cardParam[KushkiConstant::PARAMETER_CARD_NAME],
                            "Requires param card name on token request");
    }

    public function testHasCardNumberOnChargeRequest() {
        $this->createTokenRequest();
        $cardParam = $this->request->getParameter(KushkiConstant::PARAMETER_CARD);
        $this->assertEquals($this->randomCardNumber,
                            $cardParam[KushkiConstant::PARAMETER_CARD_NUMBER],
                            "Requires param card number on token request");
    }

    public function testHasCardExpMonthOnChargeRequest() {
        $this->createTokenRequest();
        $cardParam = $this->request->getParameter(KushkiConstant::PARAMETER_CARD);
        $this->assertEquals($this->randomCardExpMonth,
                            $cardParam[KushkiConstant::PARAMETER_CARD_EXP_MONTH],
                            "Requires param card expiry month on token request");
    }

    public function testHasCardExpYearOnChargeRequest() {
        $this->createTokenRequest();
        $cardParam = $this->request->getParameter(KushkiConstant::PARAMETER_CARD);
        $this->assertEquals($this->randomCardExpYear,
                            $cardParam[KushkiConstant::PARAMETER_CARD_EXP_YEAR],
                            "Requires param card expiry year on token request");
    }

    public function testHasCardCvvOnChargeRequest() {
        $this->createTokenRequest();
        $cardParam = $this->request->getParameter(KushkiConstant::PARAMETER_CARD);
        $this->assertEquals($this->randomCardCvv,
                            $cardParam[KushkiConstant::PARAMETER_CARD_CVC],
                            "Requires param card CVV on token request");
    }

    public function testThrowExceptionOnIncorrectParameter() {
        $this->createTokenRequest();

        $this->setExpectedException(
            'kushki\lib\KushkiException', 'Parameter does not exist', 0
        );
        $this->request->getParameter(CommonUtils::randomAlphaString());
    }
}
