<?php
namespace kushki\tests\inttests\lib;

use kushki\lib\Kushki;
use kushki\lib\KushkiConstant;

use kushki\lib\KushkiCurrencies;
use kushki\lib\KushkiLanguages;
use kushki\tests\lib\CommonUtils;

require_once realpath(dirname(__FILE__)) . '/../../lib/CommonUtils.php';

class KushkiIntTest extends \PHPUnit_Framework_TestCase {
    protected $kushki;

    protected function setUp() {
        $merchantId = '10000001408518323354818001';
        $idioma = KushkiLanguages::ES;
        $moneda = KushkiCurrencies::USD;
        $this->kushki = new Kushki($merchantId, $idioma, $moneda);;
    }

    public function testShouldReturnSuccessfulTokenTransaction_TC_001() {
        $tokenTransaction = $this->getValidTokenTransaction();
        $this->assertEquals(true, $tokenTransaction->isSuccessful());
        $this->assertEquals("Transacción aprobada", $tokenTransaction->getResponseText());
        $this->assertEquals("000", $tokenTransaction->getResponseCode());
    }

    public function testShouldReturnNonSuccessfulTokenTransactionInvalidCard_TC_002() {
        $cardParams = array(
            KushkiConstant::PARAMETER_CARD_NAME => "John Doe",
            KushkiConstant::PARAMETER_CARD_NUMBER => "5411111111115854",
            KushkiConstant::PARAMETER_CARD_EXP_MONTH => "12",
            KushkiConstant::PARAMETER_CARD_EXP_YEAR => "20",
            KushkiConstant::PARAMETER_CARD_CVC => "123",
        );
        $tokenTransaction = $this->kushki->requestToken($cardParams);
        $this->assertEquals(false, $tokenTransaction->isSuccessful());
        $this->assertEquals("Tarjeta no válida", $tokenTransaction->getResponseText());
        $this->assertEquals("017", $tokenTransaction->getResponseCode());
    }

    public function testShouldReturnSuccessfulChargeTransaction_TC_006() {
        $tokenTransaction = $this->getValidTokenTransaction();
        $amount = CommonUtils::getRandomAmount();
        $token = $tokenTransaction->getToken();

        $chargeTransaction = $this->kushki->charge($token, $amount);

        $this->assertEquals(true, $tokenTransaction->isSuccessful());
        $this->assertEquals(true, $chargeTransaction->isSuccessful());
        $this->assertEquals("Transacción aprobada", $chargeTransaction->getResponseText());
        $this->assertEquals("000", $chargeTransaction->getResponseCode());
    }

    public function testShouldReturnNonSuccessfulChargeTransactionInvalidToken_TC_008() {
        $amount = CommonUtils::getRandomAmount();
        $token =  "k7jwynu59sd28wu81i2ygsyvllyfimju";

        $chargeTransaction = $this->kushki->charge($token, $amount);

        $this->assertEquals(false, $chargeTransaction->isSuccessful());
        $this->assertEquals("El token de la transacción no es válido", $chargeTransaction->getResponseText());
        $this->assertEquals("574", $chargeTransaction->getResponseCode());
    }

    private function getValidTokenTransaction() {
        $cardParams = array(
            KushkiConstant::PARAMETER_CARD_NAME => "John Doe",
            KushkiConstant::PARAMETER_CARD_NUMBER => "4111111111111111",
            KushkiConstant::PARAMETER_CARD_EXP_MONTH => "12",
            KushkiConstant::PARAMETER_CARD_EXP_YEAR => "20",
            KushkiConstant::PARAMETER_CARD_CVC => "123",
        );
        return $this->kushki->requestToken($cardParams);
    }
}
