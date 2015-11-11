<?php
namespace kushki\tests\unit\lib;

use kushki\lib\KushkiConstant;
use kushki\lib\KushkiCurrencys;
use kushki\lib\KushkiLanguages;
use kushki\lib\RequestBuilder;

class RequestTest extends \PHPUnit_Framework_TestCase
{

    private $request;
    private $randomUrl;
    private $params;
    private $randomMerchantId;
    private $language = KushkiLanguages::ES;
    private $currency = KushkiCurrencys::USD;
    private $randomTransactionAmount;
    private $randomTransactionToken;
    private $randomCardName;
    private $randomCardNumber = '4242424242424242';
    private $expiredMonth = '01';
    private $expiredYear;
    private $cvc;
    private $deferred = true;
    private $months = 3;

    private function createChargeRequest()
    {
        $this->randomUrl = Utils::randomAlphaNumberString();
        $this->randomMerchantId = Utils::randomAlphaNumberString();
        $this->randomTransactionToken = Utils::randomAlphaNumberString();
        $this->randomTransactionAmount = rand(1, 9999);

        $this->request = RequestBuilder::createChargeRequest($this->randomUrl,
            $this->randomTransactionToken,
            $this->randomTransactionAmount, $this->currency,
            $this->randomMerchantId,
            $this->language);
    }

    private function createTokenRequest()
    {
        $this->randomUrl = Utils::randomAlphaNumberString();
        $this->randomMerchantId = Utils::randomAlphaNumberString();
        $this->randomCardName = Utils::randomAlphaString();
        $this->expiredYear = rand(20, 99);
        $this->cvc = rand(100, 999);;

        $this->request = RequestBuilder::createTokenRequest($this->randomUrl, $this->randomMerchantId,
            $this->language, $this->randomCardName,
            $this->randomCardNumber, $this->expiredMonth,
            $this->expiredYear, $this->cvc, $this->deferred, $this->months);
    }

    public function testHasContentTypeOnChargeRequest()
    {
        $this->createChargeRequest();
        $this->assertEquals(KushkiConstant::CONTENT_TYPE, $this->request->getContentType(),
            "Need have content type");
    }

    public function testHasTokenOnChargeRequest()
    {
        $this->createChargeRequest();
        $this->assertEquals($this->randomTransactionToken,
            $this->request->getParameter(KushkiConstant::PARAMETER_TRANSACTION_TOKEN),
            "Need have param token");
    }

    public function testHasAmountOnChargeRequest()
    {
        $this->createChargeRequest();
        $this->assertEquals($this->randomTransactionAmount,
            $this->request->getParameter(KushkiConstant::PARAMETER_TRANSACTION_AMOUNT),
            "Need have param amount");
    }

    public function testHasCurrencyOnChargeRequest()
    {
        $this->createChargeRequest();
        $this->assertEquals($this->currency,
            $this->request->getParameter(KushkiConstant::PARAMETER_CURRENCY_CODE),
            "Need have param currency");
    }

    public function testHasMerchantIdOnChargeRequest()
    {
        $this->createChargeRequest();
        $this->assertEquals($this->randomMerchantId,
            $this->request->getParameter(KushkiConstant::PARAMETER_MERCHANT_ID),
            "Need have param merchant_id on charge request");
    }

    public function testHasMerchantIdOnTokenRequest()
    {
        $this->createTokenRequest();
        $this->assertEquals($this->randomMerchantId,
            $this->request->getParameter(KushkiConstant::PARAMETER_MERCHANT_ID),
            "Need have param merchant_id on token request");
    }

    public function testHasCardNameOnTokenRequest()
    {
        $this->createTokenRequest();
        $this->assertEquals($this->randomCardName,
            $this->request->getParameter(KushkiConstant::PARAMETER_CARD)[KushkiConstant::PARAMETER_CARD_NAME],
            "Need have param card-name");
    }

    public function testHasCardNumberOnTokenRequest()
    {
        $this->createTokenRequest();
        $this->assertEquals($this->randomCardNumber,
            $this->request->getParameter(KushkiConstant::PARAMETER_CARD)[KushkiConstant::PARAMETER_CARD_NUMBER],
            "Need have param card-number");
    }

    public function testHasCardExpMonthOnTokenRequest()
    {
        $this->createTokenRequest();
        $this->assertEquals($this->expiredMonth,
            $this->request->getParameter(KushkiConstant::PARAMETER_CARD)[KushkiConstant::PARAMETER_CARD_EXP_MONTH],
            "Need have param card-exp_month");
    }

    public function testHasCardExpYearOnTokenRequest()
    {
        $this->createTokenRequest();
        $this->assertEquals($this->expiredYear,
            $this->request->getParameter(KushkiConstant::PARAMETER_CARD)[KushkiConstant::PARAMETER_CARD_EXP_YEAR],
            "Need have param card-exp_year");
    }

    public function testHasCardCvcOnTokenRequest()
    {
        $this->createTokenRequest();
        $this->assertEquals($this->cvc,
            $this->request->getParameter(KushkiConstant::PARAMETER_CARD)[KushkiConstant::PARAMETER_CARD_CVC],
            "Need have param card-cvc");
    }

    public function testHasDeferredOnTokenRequest()
    {
        $this->createTokenRequest();
        $this->assertEquals($this->deferred,
            $this->request->getParameter(KushkiConstant::PARAMETER_DEFERRED),
            "Need have param deferred");
    }

    public function testHasMonthsOnTokenRequest()
    {
        $this->createTokenRequest();
        $this->assertEquals($this->months,
            $this->request->getParameter(KushkiConstant::PARAMETER_MONTHS),
            "Need have param months");
    }

    public function testHasContentTypeOnTokenRequest()
    {
        $this->createTokenRequest();
        $this->assertEquals(KushkiConstant::CONTENT_TYPE, $this->request->getContentType(),
            "Need have content type");
    }
}
