<?php
namespace kushki\tests\unit\lib;

use kushki\lib\KushkiConstant;
use kushki\lib\KushkiCurrencies;
use kushki\lib\KushkiLanguages;
use kushki\lib\RequestBuilder;
use PHPUnit_Framework_TestCase;

class RequestTest extends PHPUnit_Framework_TestCase
{

    private $request;
    private $randomUrl;
    private $randomMerchantId;
    private $language = KushkiLanguages::ES;
    private $currency = KushkiCurrencies::USD;
    private $randomTransactionAmount;
    private $randomTransactionToken;

    private function createChargeRequest()
    {
        $this->randomUrl = Utils::randomAlphaNumberString();
        $this->randomMerchantId = Utils::randomAlphaNumberString();
        $this->randomTransactionToken = Utils::randomAlphaNumberString();
        $this->randomTransactionAmount = rand(1, 9999);

        $builder = new RequestBuilder();
        $builder->setUrl($this->randomUrl);
        $builder->setToken($this->randomTransactionToken);
        $builder->setAmount($this->randomTransactionAmount);
        $builder->setCurrency($this->currency);
        $builder->setMerchantId($this->randomMerchantId);
        $builder->setLanguage( $this->language);

        $this->request = $builder->createChargeRequest();
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

    public function testThrowExceptionOnIncorrectParameter()
    {
        $this->createChargeRequest();

        $this->setExpectedException(
            'kushki\lib\KushkiException', 'Parameter do not exist', 0
        );
        $this->request->getParameter(Utils::randomAlphaString());
    }
}
