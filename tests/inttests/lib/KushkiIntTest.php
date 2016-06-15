<?php
namespace kushki\tests\inttests\lib;

use kushki\lib\Kushki;
use kushki\lib\KushkiConstant;
use kushki\lib\KushkiEnvironment;
use kushki\lib\KushkiCurrency;
use kushki\lib\KushkiLanguages;
use kushki\tests\lib\CommonUtils;

require_once dirname(__FILE__) . '/../../lib/CommonUtils.php';
require_once dirname(__FILE__) . '/TokenHelper.php';

class KushkiIntTest extends \PHPUnit_Framework_TestCase {
    protected $kushki;
    protected $secretKushki;

    protected $merchantId;

    const MERCHANT_ID = "10000001641310597258111220";
    const SECRET_MERCHANT_ID = "10000001641344874123111220";

    protected function setUp() {
        $this->merchantId = self::MERCHANT_ID;
        $secretMerchantId = self::SECRET_MERCHANT_ID;
        $idioma = KushkiLanguages::ES;
        $moneda = KushkiCurrency::USD;
        $this->kushki = new Kushki($this->merchantId, $idioma, $moneda, KushkiEnvironment::TESTING);
        $this->secretKushki = new Kushki($secretMerchantId, $idioma, $moneda, KushkiEnvironment::TESTING);
    }

    public function testShouldReturnSuccessfulTokenTransaction_TC_001() {
        $tokenTransaction = TokenHelper::getValidTokenTransaction($this->merchantId);
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
        $tokenTransaction = TokenHelper::requestToken($this->merchantId, $cardParams);
        $this->assertsTransaction($tokenTransaction, false, "Tarjeta no válida", "017");
    }

    public function testShouldReturnSuccessfulChargeTransaction_TC_006() {
        $tokenTransaction = TokenHelper::getValidTokenTransaction($this->merchantId);
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

        $this->assertsTransaction($chargeTransaction, false, "ID de comercio no válido", "201");
    }

    /**
     * @group failing
     * Tests the api edit form
     */
    public function testShouldReturnSuccessfulVoidTransaction_TC_014() {
        $tokenTransaction = TokenHelper::getValidTokenTransaction($this->merchantId);
        $amount = CommonUtils::getRandomAmount();
        $token = $tokenTransaction->getToken();
        sleep(CommonUtils::THREAD_SLEEP);
        $chargeTransaction = $this->secretKushki->charge($token, $amount);
        $ticket = $chargeTransaction->getTicketNumber();

        sleep(CommonUtils::THREAD_SLEEP);
        $voidTransaction = $this->secretKushki->voidCharge($ticket, $amount);

        $this->assertsValidTransaction($tokenTransaction);
        $this->assertsValidTransaction($chargeTransaction);
        $this->assertsValidTransaction($voidTransaction);
    }

    public function testShouldReturnSuccessfulDeferredChargeTransaction_TC_026() {
        $tokenTransaction = TokenHelper::getValidTokenTransaction($this->merchantId);
        $amount = CommonUtils::getRandomAmount();
        $token = $tokenTransaction->getToken();
        $monthsDeferred = array(3, 6, 9, 12);
        $months = $monthsDeferred[array_rand($monthsDeferred)];

        sleep(CommonUtils::THREAD_SLEEP);
        $deferredChargeTransaction = $this->secretKushki->deferredCharge($token, $amount, $months);

        $this->assertsValidTransaction($tokenTransaction);
        $this->assertsValidTransaction($deferredChargeTransaction);
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
