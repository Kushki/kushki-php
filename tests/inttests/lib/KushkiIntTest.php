<?php
namespace kushki\tests\inttests\lib;

use kushki\lib\Kushki;
use kushki\lib\KushkiConstant;

use kushki\lib\KushkiCurrencies;
use kushki\lib\KushkiLanguages;
use kushki\tests\lib\CommonUtils;

require_once dirname(__FILE__) . '/../../lib/CommonUtils.php';

class KushkiIntTest extends \PHPUnit_Framework_TestCase {
    protected $kushki;
    protected $secretKushki;

    const MERCHANT_ID = "10000001641080185390111217";
    const SECRET_MERCHANT_ID = "10000001641088709280111217";

    protected function setUp() {
        $merchantId = self::MERCHANT_ID;
        $secretMerchantId = self::SECRET_MERCHANT_ID;
        $idioma = KushkiLanguages::ES;
        $moneda = KushkiCurrencies::USD;
        $this->kushki = new Kushki($merchantId, $idioma, $moneda);;
        $this->secretKushki = new Kushki($secretMerchantId, $idioma, $moneda);;
    }

    public function testShouldReturnSuccessfulTokenTransaction_TC_001() {
        $tokenTransaction = $this->getValidTokenTransaction();
        $this->assertsValidTransaction($tokenTransaction);
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
        $this->assertsTransaction($tokenTransaction, false, "Tarjeta no válida", "017");
    }

    public function testShouldReturnSuccessfulChargeTransaction_TC_006() {
        $tokenTransaction = $this->getValidTokenTransaction();
        $amount = CommonUtils::getRandomAmount();
        $token = $tokenTransaction->getToken();

        sleep(CommonUtils::THREAD_SLEEP);

        $chargeTransaction = $this->secretKushki->charge($token, $amount);

        $this->assertsValidTransaction($tokenTransaction);
        $this->assertsValidTransaction($chargeTransaction);
    }

    public function testShouldReturnNonSuccessfulChargeTransactionInvalidToken_TC_008() {
        $amount = CommonUtils::getRandomAmount();
        $token = "k7jwynu59sd28wu81i2ygsyvllyfimju";

        $chargeTransaction = $this->secretKushki->charge($token, $amount);

        $this->assertsTransaction($chargeTransaction, false, "El token de la transacción no es válido", "577");
    }

    public function testShouldReturnSuccessfulRefundTransaction_TC_009() {
        $tokenTransaction = $this->getValidTokenTransaction();
        $amount = CommonUtils::getRandomAmount();
        $token = $tokenTransaction->getToken();
        sleep(CommonUtils::THREAD_SLEEP);
        $chargeTransaction = $this->secretKushki->charge($token, $amount);
        $ticket = $chargeTransaction->getTicketNumber();

        sleep(CommonUtils::THREAD_SLEEP);
        $refundTransaction = $this->secretKushki->refundCharge($ticket, $amount);

        $this->assertsValidTransaction($tokenTransaction);
        $this->assertsValidTransaction($chargeTransaction);
        $this->assertsValidTransaction($refundTransaction);
    }
    
    public function testShouldReturnFailedRefundTransactionNoTicket_TC_012() {
        $amount = CommonUtils::getRandomAmount();

        $refundTransaction = $this->secretKushki->refundCharge("", $amount);

        $this->assertsTransaction($refundTransaction, false, "El número de ticket de la transacción es requerido", "705");
    }

    public function testShouldReturnSuccessfulVoidTransaction_TC_014() {
        $this->markTestSkipped('working on charge');

        $tokenTransaction = $this->getValidTokenTransaction();
        $amount = CommonUtils::getRandomAmount();
        $voidAmount = CommonUtils::getRandomDoubleAmount();
        $token = $tokenTransaction->getToken();
        sleep(CommonUtils::THREAD_SLEEP);
        $chargeTransaction = $this->secretKushki->charge($token, $amount);
        $ticket = $chargeTransaction->getTicketNumber();

        sleep(CommonUtils::THREAD_SLEEP);
        $voidTransaction = $this->secretKushki->voidCharge($ticket, $voidAmount);

        $this->assertsValidTransaction($tokenTransaction);
        $this->assertsValidTransaction($chargeTransaction);
        $this->assertsValidTransaction($voidTransaction);
    }

    public function testShouldReturnFailedVoidTransactionInvalidTicket_TC_019() {
        $this->markTestSkipped('working on charge');

        $amount = CommonUtils::getRandomDoubleAmount();
        $ticket = "153633977318400068";

        $refundTransaction = $this->secretKushki->refundCharge($ticket, $amount);

        $this->assertsTransaction($refundTransaction, false, "Transacción no encontrada", "222");
    }

    public function testShouldReturnSuccessfulDeferredChargeTransaction_TC_026() {
        $tokenTransaction = $this->getValidTokenTransaction();
        $amount = CommonUtils::getRandomAmount();
        $token = $tokenTransaction->getToken();
        $months = rand(1, 22);

        sleep(CommonUtils::THREAD_SLEEP);
        $deferredChargeTransaction = $this->secretKushki->deferredCharge($token, $amount, $months);

        $this->assertsValidTransaction($tokenTransaction);
        $this->assertsValidTransaction($deferredChargeTransaction);
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

    private function assertsTransaction($transaction, $isSuccessful, $expectedMessage, $expectedCode) {

        if ($isSuccessful != $transaction->isSuccessful()) {
            print "\nIs successful? " . $transaction->isSuccessful() . " | Expected: " . $isSuccessful;
            print "\nResponse text: " . $transaction->getResponseText() . " | Expected: " . $expectedMessage;
            print "\nResponse code: " . $transaction->getResponseCode() . " | Expected: " . $expectedCode;
            print "\n";
        }

        $this->assertEquals($isSuccessful, $transaction->isSuccessful());
        $this->assertEquals($expectedMessage, $transaction->getResponseText());
        $this->assertEquals($expectedCode, $transaction->getResponseCode());
    }

    private function assertsValidTransaction($transaction) {
        $this->assertsTransaction($transaction, true, "Transacción aprobada", "000");
    }

}
