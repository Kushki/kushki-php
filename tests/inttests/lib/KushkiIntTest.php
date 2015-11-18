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
        $this->assertEquals(200, $response->getResponseCode());
    }

    public function testMustGet402ResponseCodeWhenChargeBeDeclined()
    {
        $declinedToken = "123456789-declined";
        $request = $this->createRequest($declinedToken);
        $kushki = new Kushki($request->getParameter(KushkiConstant::PARAMETER_MERCHANT_ID),
            $request->getParameter(KushkiConstant::PARAMETER_LANGUAGE),
            $request->getParameter(KushkiConstant::PARAMETER_CURRENCY_CODE));

        $response = $kushki->charge($declinedToken, $request->getParameter(KushkiConstant::PARAMETER_TRANSACTION_AMOUNT));
        $this->assertEquals(402, $response->getResponseCode());
    }

    private function createRequest($token)
    {
        $amount = rand(1, 1000);
        $currency = KushkiCurrencies::USD;
        $merchantId = "MERCHANT-PRIVATE-ID";
        $request = RequestBuilder::createChargeRequest(KushkiConstant::CHARGE_URL, $token, $amount, $currency, $merchantId, KushkiLanguages::ES);
        return $request;
    }
}
