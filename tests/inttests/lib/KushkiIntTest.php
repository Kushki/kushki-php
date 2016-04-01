<?php
namespace kushki\tests\inttests\lib;

use kushki\lib\Kushki;
use kushki\lib\KushkiConstant;

use kushki\lib\KushkiCurrencies;
use kushki\lib\KushkiLanguages;
use kushki\tests\lib\CommonUtils;

//require_once realpath(dirname(__FILE__)) . '/../../lib/CommonUtils.php';
require_once dirname(__FILE__) . '/../../lib/CommonUtils.php';

class KushkiIntTest extends \PHPUnit_Framework_TestCase {
    protected $kushki;

    const MERCHANT_ID = "10000001604958481814111215";

    protected function setUp() {
        $merchantId = self::MERCHANT_ID;
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

        sleep(CommonUtils::THREAD_SLEEP);

        $chargeTransaction = $this->kushki->charge($token, $amount);

        $this->assertEquals(true, $tokenTransaction->isSuccessful());
        $this->assertEquals(true, $chargeTransaction->isSuccessful());
        $this->assertEquals("Transacción aprobada", $chargeTransaction->getResponseText());
        $this->assertEquals("000", $chargeTransaction->getResponseCode());
    }

    public function testShouldReturnNonSuccessfulChargeTransactionInvalidToken_TC_008() {
        $amount = CommonUtils::getRandomAmount();
        $token = "k7jwynu59sd28wu81i2ygsyvllyfimju";

        $chargeTransaction = $this->kushki->charge($token, $amount);

        $this->assertEquals(false, $chargeTransaction->isSuccessful());
        $this->assertEquals("El token de la transacción no es válido", $chargeTransaction->getResponseText());
        $this->assertEquals("577", $chargeTransaction->getResponseCode());
    }

    public function testShouldReturnSuccessfulRefundTransaction_TC_009() {
        $tokenTransaction = $this->getValidTokenTransaction();
        $amount = CommonUtils::getRandomAmount();
        $token = $tokenTransaction->getToken();
        sleep(CommonUtils::THREAD_SLEEP);
        $chargeTransaction = $this->kushki->charge($token, $amount);
        $ticket = $chargeTransaction->getTicketNumber();

        sleep(CommonUtils::THREAD_SLEEP);
        $refundTransaction = $this->kushki->refundCharge($ticket, $amount);

        $this->assertEquals(true, $tokenTransaction->isSuccessful());
        $this->assertEquals(true, $chargeTransaction->isSuccessful());
        $this->assertEquals(true, $refundTransaction->isSuccessful());
        $this->assertEquals("Transacción aprobada", $refundTransaction->getResponseText());
        $this->assertEquals("000", $refundTransaction->getResponseCode());
    }

    public function testShouldReturnFailedRefundTransactionNoTicket_TC_012() {
        $amount = CommonUtils::getRandomAmount();

        $refundTransaction = $this->kushki->refundCharge("", $amount);

        $this->assertEquals(false, $refundTransaction->isSuccessful());
        $this->assertEquals("El número de ticket de la transacción es requerido", $refundTransaction->getResponseText());
        $this->assertEquals("705", $refundTransaction->getResponseCode());
    }

    public function testShouldReturnSuccessfulVoidTransaction_TC_014() {
        $tokenTransaction = $this->getValidTokenTransaction();
        $amount = CommonUtils::getRandomAmount();
        $token = $tokenTransaction->getToken();
        sleep(CommonUtils::THREAD_SLEEP);
        $chargeTransaction = $this->kushki->charge($token, $amount);
        $ticket = $chargeTransaction->getTicketNumber();

        sleep(CommonUtils::THREAD_SLEEP);
        $voidTransaction = $this->kushki->voidCharge($ticket, $amount);

        $this->assertEquals(true, $tokenTransaction->isSuccessful());
        $this->assertEquals(true, $chargeTransaction->isSuccessful());
        $this->assertEquals(true, $voidTransaction->isSuccessful());
        $this->assertEquals("Transacción aprobada", $voidTransaction->getResponseText());
        $this->assertEquals("000", $voidTransaction->getResponseCode());
    }

    public function testShouldReturnFailedVoidTransactionInvalidTicket_TC_019() {
        $amount = CommonUtils::getRandomAmount();
        $ticket = "153633977318400068";

        $refundTransaction = $this->kushki->refundCharge($ticket, $amount);

        $this->assertEquals(false, $refundTransaction->isSuccessful());
        $this->assertEquals("Transacción no encontrada", $refundTransaction->getResponseText());
        $this->assertEquals("222", $refundTransaction->getResponseCode());
    }

    public function testShouldReturnSuccessfulDeferredChargeTransaction_TC_026() {
        $tokenTransaction = $this->getValidTokenTransaction();
        $amount = CommonUtils::getRandomAmount();
        $token = $tokenTransaction->getToken();
        $months = rand(1, 22);
        $interest = rand(1, 25) / 100;

        sleep(CommonUtils::THREAD_SLEEP);
        $deferredChargeTransaction = $this->kushki->deferredCharge($token, $amount, $months, $interest);

        $this->assertEquals(true, $tokenTransaction->isSuccessful());
        $this->assertEquals(true, $deferredChargeTransaction->isSuccessful());
        $this->assertEquals("Transacción aprobada", $deferredChargeTransaction->getResponseText());
        $this->assertEquals("000", $deferredChargeTransaction->getResponseCode());
    }

    private function getValidTokenTransaction() {
        $cardParams = array(
            KushkiConstant::PARAMETER_CARD_NAME => "John Doe",
            KushkiConstant::PARAMETER_CARD_NUMBER => "4017779991118888",
            KushkiConstant::PARAMETER_CARD_EXP_MONTH => "12",
            KushkiConstant::PARAMETER_CARD_EXP_YEAR => "21",
            KushkiConstant::PARAMETER_CARD_CVC => "123",
        );
        return $this->kushki->requestToken($cardParams);
    }
}
