<?php
namespace kushki\tests\inttests\lib;

use kushki\lib\Kushki;
use kushki\lib\KushkiConstant;
use kushki\lib\KushkiCurrencies;
use kushki\lib\KushkiLanguages;
use kushki\lib\RequestBuilder;

class KushkiIntTest extends \PHPUnit_Framework_TestCase
{

    public function testMustGet200ResponseCodeWhenChargeBeOk()
    {
        $successToken = "d0099d11-f443-4e54-b7aa-6ede163c94c9";
        $request = $this->createRequest($successToken);
        $kushki = new Kushki($request->getParameter(KushkiConstant::PARAMETER_MERCHANT_ID),
                                $request->getParameter(KushkiConstant::PARAMETER_LANGUAGE),
                                $request->getParameter(KushkiConstant::PARAMETER_CURRENCY_CODE));

        $response = $kushki->charge($successToken, $request->getParameter(KushkiConstant::PARAMETER_TRANSACTION_AMOUNT));
        $this->assertEquals(true, $response->isSuccessful());
        $this->assertEquals(true, is_string($response->getTicketNumber()));
    }

    public function testMustGet402ResponseCodeWhenChargeBeDeclined()
    {
        $declinedToken = "123456789-declined";
        $request = $this->createRequest($declinedToken);
        $kushki = new Kushki($request->getParameter(KushkiConstant::PARAMETER_MERCHANT_ID),
            $request->getParameter(KushkiConstant::PARAMETER_LANGUAGE),
            $request->getParameter(KushkiConstant::PARAMETER_CURRENCY_CODE));

        $response = $kushki->charge($declinedToken, $request->getParameter(KushkiConstant::PARAMETER_TRANSACTION_AMOUNT));
        $this->assertEquals(false, $response->isSuccessful());
        $this->assertEquals(true, is_string($response->getResponseText()));
    }

    private function createRequest($token)
    {
        $amount = rand(1, 1000);
        $currency = KushkiCurrencies::USD;
        $merchantId = "MERCHANT-PRIVATE-ID";
        $builder = new RequestBuilder();
        $builder->setUrl(KushkiConstant::CHARGE_URL);
        $builder->setToken($token);
        $builder->setAmount($amount);
        $builder->setCurrency($currency);
        $builder->setMerchantId($merchantId);
        $builder->setLanguage(KushkiLanguages::ES);

        $request = $builder->createChargeRequest();

        return $request;
    }
}
