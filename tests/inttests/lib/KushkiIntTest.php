<?php
namespace kushki\tests\inttests\lib;

use kushki\lib\Kushki;
use kushki\lib\KushkiConstant;
use kushki\lib\KushkiEnvironment;
use kushki\lib\KushkiCurrency;
use kushki\lib\KushkiLanguage;
use kushki\tests\lib\CommonUtils;

require_once dirname(__FILE__) . '/../../lib/CommonUtils.php';
require_once dirname(__FILE__) . '/TokenHelper.php';

class KushkiIntTest extends \PHPUnit_Framework_TestCase {
    protected $kushki;
    protected $kushkiColombia;
    protected $secretKushki;
    protected $secretKushkiColombia;

    const MERCHANT_ID = "10000001641310597258111220";
    const SECRET_MERCHANT_ID = "10000001641344874123111220";
    const MERCHANT_ID_COLOMBIA = "10000001958318993042555001";
    const SECRET_MERCHANT_ID_COLOMBIA = "10000001958363505343555001";

    protected function setUp() {
        $idioma = KushkiLanguage::ES;

        $this->kushki = new Kushki(self::MERCHANT_ID, $idioma, KushkiCurrency::USD, KushkiEnvironment::TESTING);
        $this->secretKushki = new Kushki(self::SECRET_MERCHANT_ID, $idioma, KushkiCurrency::USD, KushkiEnvironment::TESTING);

        $this->kushkiColombia = new Kushki(self::MERCHANT_ID_COLOMBIA, $idioma, KushkiCurrency::COP,
            KushkiEnvironment::TESTING);
        $this->secretKushkiColombia = new Kushki(self::SECRET_MERCHANT_ID_COLOMBIA, $idioma, KushkiCurrency::COP,
            KushkiEnvironment::TESTING);
    }

    public function testShouldReturnSuccessfulTokenTransaction_TC_001() {
        $amount = CommonUtils::getRandomAmount();
        $tokenTransaction = TokenHelper::getValidTokenTransaction(self::MERCHANT_ID, $amount);
        $this->assertsValidTransaction($tokenTransaction);
    }

    public function testShouldReturnSuccessfulTokenTransaction_TC_001Colombia() {
        $amount = CommonUtils::getRandomAmountColombia();
        $tokenTransaction = TokenHelper::getValidTokenTransactionColombia(self::MERCHANT_ID_COLOMBIA, $amount);
        $this->assertsValidTransaction($tokenTransaction);
    }

    public function testShouldReturnNonSuccessfulTokenTransactionInvalidCard_TC_002() {
        $cardParams = array(
            "name" => "John Doe",
            "number" => "5411111111115854",
            "expiry_month" => "12",
            "expiry_year" => "20",
            "cvv" => "123",
            "amount" => CommonUtils::getRandomAmount()

        );
        $tokenTransaction = TokenHelper::requestToken(self::MERCHANT_ID, $cardParams, KushkiCurrency::USD);
        $this->assertsTransaction($tokenTransaction, false, "Tarjeta no válida", "017");
    }

    public function testShouldReturnNonSuccessfulTokenTransactionInvalidCard_TC_002Colombia() {
        $cardParams = array(
            "name" => "John Doe",
            "number" => "85945849584958433",
            "expiry_month" => "11",
            "expiry_year" => "21",
            "cvv" => "444",
            "amount" => CommonUtils::getRandomAmountColombia()

        );
        $tokenTransaction = TokenHelper::requestToken(self::MERCHANT_ID_COLOMBIA, $cardParams, KushkiCurrency::COP);
        $this->assertsTransaction($tokenTransaction, false, "Tarjeta no válida", "017");
    }

    public function testShouldReturnSuccessfulChargeTransaction_TC_006() {
        $amount = CommonUtils::getRandomAmount();
        $tokenTransaction = TokenHelper::getValidTokenTransaction(self::MERCHANT_ID, $amount);
        $token = $tokenTransaction->getToken();

        sleep(CommonUtils::THREAD_SLEEP);

        $chargeTransaction = $this->secretKushki->charge($token, $amount);

        $this->assertsValidTransaction($tokenTransaction);
        $this->assertsValidTransaction($chargeTransaction);
    }

    // TODO: Uncomment this test when Colombian charge transactions work again
    // public function testShouldReturnSuccessfulChargeTransaction_TC_006Colombia() {
    //     $amount = CommonUtils::getRandomAmountColombia();
    //     $tokenTransaction = TokenHelper::getValidTokenTransactionColombia(self::MERCHANT_ID_COLOMBIA, $amount);
    //     $token = $tokenTransaction->getToken();

    //     sleep(CommonUtils::THREAD_SLEEP);

    //     $chargeTransaction = $this->secretKushkiColombia->charge($token, $amount);

    //     $this->assertsValidTransaction($tokenTransaction);
    //     $this->assertsValidTransaction($chargeTransaction);
    // }

    public function testShouldReturnNonSuccessfulChargeTransactionInvalidToken_TC_008() {
        $amount = CommonUtils::getRandomAmount();
        $token = "k7jwynu59sd28wu81i2ygsyvllyfimju";

        $chargeTransaction = $this->secretKushki->charge($token, $amount);

        $this->assertsTransaction($chargeTransaction, false, "ID de comercio no válido", "201");
    }

    public function testShouldReturnNonSuccessfulChargeTransactionInvalidToken_TC_008Colombia() {
        $amount = CommonUtils::getRandomAmountColombia();
        $token = "k7jwynu59sd28wu81i2ygsyvllyfimju";

        $chargeTransaction = $this->secretKushkiColombia->charge($token, $amount);

        $this->assertsTransaction($chargeTransaction, false, "ID de comercio no válido", "201");
    }

    /**
     * @group failing
     * Tests the api edit form
     */
    public function testShouldReturnSuccessfulVoidTransaction_TC_014() {
        $amount = CommonUtils::getRandomAmount();
        $tokenTransaction = TokenHelper::getValidTokenTransaction(self::MERCHANT_ID, $amount);
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

// TODO: Uncomment this test when Colombian void succeeds
//    public function testShouldReturnSuccessfulVoidTransaction_TC_014Colombia() {
//        $amount = CommonUtils::getRandomAmountColombia();
//        $tokenTransaction = TokenHelper::getValidTokenTransactionColombia(self::MERCHANT_ID_COLOMBIA, $amount);
//        $token = $tokenTransaction->getToken();
//        sleep(CommonUtils::THREAD_SLEEP);
//        $chargeTransaction = $this->secretKushkiColombia->charge($token, $amount);
//        $ticket = $chargeTransaction->getTicketNumber();
//
//        sleep(CommonUtils::THREAD_SLEEP);
//        $voidTransaction = $this->secretKushkiColombia->voidCharge($ticket, $amount);
//
//        $this->assertsValidTransaction($tokenTransaction);
//        $this->assertsValidTransaction($chargeTransaction);
//        $this->assertsValidTransaction($voidTransaction);
//    }

    public function testShouldReturnSuccessfulDeferredChargeTransaction_TC_026() {
        $amount = CommonUtils::getRandomAmount();
        $tokenTransaction = TokenHelper::getValidTokenTransaction(self::MERCHANT_ID, $amount);
        $token = $tokenTransaction->getToken();
        $monthsDeferred = array(3, 6, 9, 12);
        $months = $monthsDeferred[array_rand($monthsDeferred)];

        sleep(CommonUtils::THREAD_SLEEP);
        $deferredChargeTransaction = $this->secretKushki->deferredCharge($token, $amount, $months);

        $this->assertsValidTransaction($tokenTransaction);
        $this->assertsValidTransaction($deferredChargeTransaction);
    }

    // TODO: Uncomment this test when Colombian charge transactions work again
    // public function testShouldReturnSuccessfulDeferredChargeTransaction_TC_026Colombia() {
    //     $amount = CommonUtils::getRandomAmountColombia();
    //     $tokenTransaction = TokenHelper::getValidTokenTransactionColombia(self::MERCHANT_ID_COLOMBIA, $amount);
    //     $token = $tokenTransaction->getToken();
    //     $months = CommonUtils::getRandomInteger(2, 36);

    //     sleep(CommonUtils::THREAD_SLEEP);
    //     $deferredChargeTransaction = $this->secretKushkiColombia->deferredCharge($token, $amount, $months);

    //     $this->assertsValidTransaction($tokenTransaction);
    //     $this->assertsValidTransaction($deferredChargeTransaction);
    // }

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
