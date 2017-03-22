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
    protected $newSecretKushki;
    protected $secretKushkiColombia;
    protected $newSecretKushkiColombia;

    const MERCHANT_ID = "10000001641310597258111220";
    const SECRET_MERCHANT_ID = "10000001641344874123111220";
    const MERCHANT_ID_COLOMBIA = "10000001958318993042555001";
    const SECRET_MERCHANT_ID_COLOMBIA = "10000001958363505343555001";

    protected function setUp() {
        $idioma = KushkiLanguage::ES;

        $this->kushki = new Kushki(self::MERCHANT_ID, $idioma, KushkiCurrency::USD, KushkiEnvironment::TESTING);
        $this->secretKushki = new Kushki(self::SECRET_MERCHANT_ID, $idioma, KushkiCurrency::USD, KushkiEnvironment::TESTING);
        $this->newSecretKushki = new Kushki(self::SECRET_MERCHANT_ID, $idioma, KushkiCurrency::USD, KushkiEnvironment::API_TEST);

        $this->kushkiColombia = new Kushki(self::MERCHANT_ID_COLOMBIA, $idioma, KushkiCurrency::COP,
            KushkiEnvironment::TESTING);
        $this->secretKushkiColombia = new Kushki(self::SECRET_MERCHANT_ID_COLOMBIA, $idioma, KushkiCurrency::COP,
            KushkiEnvironment::TESTING);
        $this->newSecretKushkiColombia = new Kushki(self::SECRET_MERCHANT_ID_COLOMBIA, $idioma, KushkiCurrency::COP,
            KushkiEnvironment::API_TEST);
    }

    public function testShouldReturnSuccessfulTokenTransaction_TC_001() {
        $amount = CommonUtils::getRandomAmount();
        $tokenTransaction = TokenHelper::getValidTokenTransaction(self::MERCHANT_ID, $amount);
        $this->assertsValidTransaction($tokenTransaction);
    }

    public function testShouldReturnSuccessfulTokenSubscription_TC_001() {
        $amount = CommonUtils::getRandomAmount();
        $type = "subscription-token";
        $tokenSubscription = TokenHelper::getValidTokenTransaction(self::MERCHANT_ID, $amount, $type);
        $this->assertsValidApiTransaction($tokenSubscription);
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
            "amount" => CommonUtils::getRandomAmount(),
            "token_type" => "transaction-token"

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
            "amount" => CommonUtils::getRandomAmountColombia(),
            "token_type" => "transaction-token"

        );
        $tokenTransaction = TokenHelper::requestToken(self::MERCHANT_ID_COLOMBIA, $cardParams, KushkiCurrency::COP);
        $this->assertsTransaction($tokenTransaction, false, "Tarjeta no válida", "017");
    }

    public function testShouldReturnSuccessfulChargeTransaction_TC_006() {
        $amount = CommonUtils::getRandomAmount();
        $tokenTransaction = TokenHelper::getValidTokenTransaction(self::MERCHANT_ID, $amount);
        $token = $tokenTransaction->getToken();

        sleep(CommonUtils::THREAD_SLEEP);

        $chargeTransaction = $this->newSecretKushki->charge($token, $amount);

        $this->assertsValidTransaction($tokenTransaction);
        $this->assertsValidApiTransaction($chargeTransaction);
    }

    public function testShouldReturnSuccessfulChargeTransactionWithMetadata_TC_006() {
        $amount = CommonUtils::getRandomAmount();
        $tokenTransaction = TokenHelper::getValidTokenTransaction(self::MERCHANT_ID, $amount);
        $token = $tokenTransaction->getToken();
        $metadata = array("Key1"=>"value1", "Key2"=>"value2");

        sleep(CommonUtils::THREAD_SLEEP);
        $chargeTransaction = $this->newSecretKushki->charge($token, $amount, $metadata);
        $this->assertsValidTransaction($tokenTransaction);
        $this->assertsValidApiTransaction($chargeTransaction);
    }

    public function testShouldReturnSuccessfulChargeTransaction_TC_006Colombia() {
        $this->markTestSkipped('must be revisited.');

        $amount = CommonUtils::getRandomAmountColombia();
        $tokenTransaction = TokenHelper::getValidTokenTransactionColombia(self::MERCHANT_ID_COLOMBIA, $amount);
        $token = $tokenTransaction->getToken();

        sleep(CommonUtils::THREAD_SLEEP);

        $chargeTransaction = $this->newSecretKushkiColombia->charge($token, $amount);
        $this->assertsValidTransaction($tokenTransaction);
        $this->assertsValidApiTransaction($chargeTransaction);
    }

    public function testShouldReturnNonSuccessfulChargeTransactionInvalidToken_TC_008() {
        $amount = CommonUtils::getRandomAmount();
        $token = "k7jwynu59sd28wu81i2ygsyvllyfimju";

        $chargeTransaction = $this->newSecretKushki->charge($token, $amount);
        $this->assertsApiTransaction($chargeTransaction, false, "ID de comercio no válido", "201");
    }

    public function testShouldReturnNonSuccessfulChargeTransactionInvalidToken_TC_008Colombia() {
        $amount = CommonUtils::getRandomAmountColombia();
        $token = "k7jwynu59sd28wu81i2ygsyvllyfimju";

        $chargeTransaction = $this->newSecretKushkiColombia->charge($token, $amount);
        $this->assertsApiTransaction($chargeTransaction, false, "ID de comercio no válido", "201");
    }

    public function testShouldReturnSuccessfulCreateSubscription_TC_010() {
        $amount = CommonUtils::getRandomAmount();
        $type = "subscription-token";
        $tokenSubscription = TokenHelper::getValidTokenTransaction(self::MERCHANT_ID, $amount, $type);
        $token = $tokenSubscription->getToken();
        $planName = "Premium";
        $periodicity = "monthly";
        $contactDetails = array(
            "firstName" => "Lisbeth",
            "lastName" => "Salander",
            "email" => "lisbeth@salander.com");
        $starDate = "2017-01-18";
        sleep(CommonUtils::THREAD_SLEEP);

        $createSubscription = $this->newSecretKushki->createSubscription($token, $planName, $periodicity,
                                                                        $contactDetails, $amount, $starDate);
        $this->assertsValidApiTransaction($tokenSubscription);
        $this->assertsValidApiTransaction($createSubscription);
    }

    public function testShouldReturnSuccessfulCreateSubscription_TC_010Colombia() {
        $this->markTestSkipped('must be revisited.');

        $amount = CommonUtils::getRandomAmountColombia();
        $type = "subscription-token";
        $tokenSubscription = TokenHelper::getValidTokenTransactionColombia(self::MERCHANT_ID_COLOMBIA, $amount, $type);
        $token = $tokenSubscription->getToken();
        $planName = "Premium";
        $periodicity = "monthly";
        $contactDetails = array(
            "firstName" => "Lisbeth",
            "lastName" => "Salander",
            "email" => "lisbeth@salander.com");
        $starDate = "2017-01-18";
        sleep(CommonUtils::THREAD_SLEEP);

        $createSubscription = $this->newSecretKushkiColombia->createSubscription($token, $planName, $periodicity,
            $contactDetails, $amount, $starDate);
        $this->assertsValidApiTransaction($tokenSubscription);
        $this->assertsValidApiTransaction($createSubscription);
    }

    public function testShouldReturnSuccessfulCreateSubscriptionWithSubscriptionMetadata_TC_010() {
        $amount = CommonUtils::getRandomAmount();
        $type = "subscription-token";
        $tokenSubscription = TokenHelper::getValidTokenTransaction(self::MERCHANT_ID, $amount, $type);
        $token = $tokenSubscription->getToken();
        $planName = "Premium";
        $periodicity = "monthly";
        $contactDetails = array(
            "firstName" => "Lisbeth",
            "lastName" => "Salander",
            "email" => "lisbeth@salander.com");
        $starDate = "2017-01-18";
        $metadata = array("Key1"=>"value1", "Key2"=>"value2");
        sleep(CommonUtils::THREAD_SLEEP);

        $createSubscription = $this->newSecretKushki->createSubscription($token, $planName, $periodicity,
            $contactDetails, $amount, $starDate, $metadata);
        $this->assertsValidApiTransaction($tokenSubscription);
        $this->assertsValidApiTransaction($createSubscription);
    }

    public function testShouldReturnNonSuccessfulCreateSubscriptionInvalidToken_TC_012() {
        $amount = CommonUtils::getRandomAmount();
        $token = "k7jwynu59sd28wu81i2ygsyvllyfimju";
        $planName = "Premium";
        $periodicity = "monthly";
        $contactDetails = array(
            "firstName" => "Lisbeth",
            "lastName" => "Salander",
            "email" => "lisbeth@salander.com");
        $starDate = "2017-01-18";
        sleep(CommonUtils::THREAD_SLEEP);
        $createSubscription = $this->newSecretKushki->createSubscription($token, $planName, $periodicity,
            $contactDetails, $amount, $starDate);
        $this->assertsApiTransaction($createSubscription, false, "Token de suscripción no encontrado", "1019");
    }

    public function testShouldReturnSuccessfulUpdateSubscription_TC_013() {
        $amount = CommonUtils::getRandomAmount();
        $subscriptionId = $this->getSubscriptionId();
        $periodicity = "yearly";
        $currency = "USD";
        $body = array("periodicity" => $periodicity,
            "amount"=> $amount,
            "currency" => $currency);
        $updateSubscription = $this->newSecretKushki->updateSubscription($subscriptionId, $body);
        $this->assertsValidApiTransaction($updateSubscription);
    }

    public function testShouldReturnSuccessfulUpdateSubscription_TC_013Colombia() {
        $this->markTestSkipped('must be revisited.');

        $amount = CommonUtils::getRandomAmountColombia();
        $subscriptionId = $this->getSubscriptionId(true);
        $periodicity = "yearly";
        $currency = "COL";
        $body = array("periodicity" => $periodicity,
            "amount"=> $amount,
            "currency" => $currency);
        $updateSubscription = $this->newSecretKushki->updateSubscription($subscriptionId, $body);
        $this->assertsValidApiTransaction($updateSubscription);
    }

    public function testShouldReturnSuccessfulUpdateSubscriptionWithMetadata_TC_013() {
        $amount = CommonUtils::getRandomAmount();
        $subscriptionId = $this->getSubscriptionId();
        $periodicity = "yearly";
        $currency = "USD";
        $metadata = array("Key1"=>"value1", "Key2"=>"value2");
        $body = array("periodicity" => $periodicity,
            "amount"=> $amount,
            "currency" => $currency,
            "metadata" => $metadata);
        $updateSubscription = $this->newSecretKushki->updateSubscription($subscriptionId, $body);
        $this->assertsValidApiTransaction($updateSubscription);
    }

    public function testShouldReturnNonSuccessfulUpdateSubscriptionInvalidSubscriptionId_TC_013() {
        $amount = CommonUtils::getRandomAmount();
        $subscriptionId = "000000000000124";
        $periodicity = "yearly";
        $currency = "USD";
        $body = array("periodicity" => $periodicity,
            "amount"=> $amount,
            "currency" => $currency);
        $updateSubscription = $this->newSecretKushki->updateSubscription($subscriptionId, $body);
        $this->assertsApiTransaction($updateSubscription, false, "El ID de la suscripción no es válido", "1022");
    }

    public function testShouldReturnSuccessfulChargeSubscription_TC_015() {
        $subscriptionId = $this->getSubscriptionId();
        $chargeSubscription = $this->newSecretKushki->chargeSubscription($subscriptionId);
        $this->assertsValidApiTransaction($chargeSubscription);
    }

    public function testShouldReturnSuccessfulChargeSubscriptionWithMetadata_TC_015() {
        $subscriptionId = $this->getSubscriptionId();
        $metadata = array("Key1"=>"value1", "Key2"=>"value2");
        $chargeSubscription = $this->newSecretKushki->chargeSubscription($subscriptionId, $metadata);
        $this->assertsValidApiTransaction($chargeSubscription);
    }

    public function testShouldReturnNonSuccessfulChargeSubscriptionInvalidSubscriptionId_TC_015() {
        $subscriptionId = "000000000000124";
        $chargeSubscription = $this->newSecretKushki->chargeSubscription($subscriptionId);
        $this->assertsApiTransaction($chargeSubscription, false, "El ID de la suscripción no es válido", "1022");    }

    /**
     * @group failing
     * Tests the api edit form
     */
    public function testShouldReturnSuccessfulVoidTransaction_TC_014() {
        $amount = CommonUtils::getRandomAmount();
        $tokenTransaction = TokenHelper::getValidTokenTransaction(self::MERCHANT_ID, $amount);
        $token = $tokenTransaction->getToken();
        sleep(CommonUtils::THREAD_SLEEP);
        $chargeTransaction = $this->newSecretKushki->charge($token, $amount);
        $ticket = $chargeTransaction->getTicketNumber();
        sleep(CommonUtils::THREAD_SLEEP);
        $voidTransaction = $this->newSecretKushki->voidCharge($ticket);

        $this->assertsValidTransaction($tokenTransaction);
        $this->assertsValidApiTransaction($chargeTransaction);
        $this->assertsValidApiTransaction($voidTransaction);
    }

    public function testShouldReturnSuccessfulVoidTransactionWithAmount_TC_014() {
        $amount = CommonUtils::getRandomAmount();
        $tokenTransaction = TokenHelper::getValidTokenTransaction(self::MERCHANT_ID, $amount);
        $token = $tokenTransaction->getToken();
        sleep(CommonUtils::THREAD_SLEEP);
        $chargeTransaction = $this->newSecretKushki->charge($token, $amount);
        $ticket = $chargeTransaction->getTicketNumber();
        sleep(CommonUtils::THREAD_SLEEP);
        $voidTransaction = $this->newSecretKushki->voidCharge($ticket, $amount);

        $this->assertsValidTransaction($tokenTransaction);
        $this->assertsValidApiTransaction($chargeTransaction);
        $this->assertsValidApiTransaction($voidTransaction);
    }

    public function testShouldReturnSuccessfulVoidTransaction_TC_014Colombia() {
        $this->markTestSkipped('must be revisited.');

        $amount = CommonUtils::getRandomAmountColombia();
        $tokenTransaction = TokenHelper::getValidTokenTransactionColombia(self::MERCHANT_ID_COLOMBIA, $amount);
        $token = $tokenTransaction->getToken();
        sleep(CommonUtils::THREAD_SLEEP);
        $chargeTransaction = $this->newSecretKushkiColombia->charge($token, $amount);
        $ticket = $chargeTransaction->getTicketNumber(true);

        sleep(CommonUtils::THREAD_SLEEP);
        $voidTransaction = $this->newSecretKushkiColombia->voidCharge($ticket, $amount);

        $this->assertsValidTransaction($tokenTransaction);
        $this->assertsValidApiTransaction($chargeTransaction);
        $this->assertsValidTransaction($voidTransaction);
    }

    public function testShouldReturnSuccessfulDeferredChargeTransaction_TC_026() {
        $amount = CommonUtils::getRandomAmount();
        $tokenTransaction = TokenHelper::getValidTokenTransaction(self::MERCHANT_ID, $amount);
        $token = $tokenTransaction->getToken();
        $monthsDeferred = array(3, 6, 9, 12);
        $months = $monthsDeferred[array_rand($monthsDeferred)];

        sleep(CommonUtils::THREAD_SLEEP);
        $deferredChargeTransaction = $this->newSecretKushki->deferredCharge($token, $amount, $months);

        $this->assertsValidTransaction($tokenTransaction);
        $this->assertsValidApiTransaction($deferredChargeTransaction);
    }

    public function testShouldReturnSuccessfulDeferredChargeTransaction_with_metadata_TC_026() {
        $amount = CommonUtils::getRandomAmount();
        $tokenTransaction = TokenHelper::getValidTokenTransaction(self::MERCHANT_ID, $amount);
        $token = $tokenTransaction->getToken();
        $monthsDeferred = array(3, 6, 9, 12);
        $months = $monthsDeferred[array_rand($monthsDeferred)];
        $metadata = array("Key1"=>"value1", "Key2"=>"value2");
        sleep(CommonUtils::THREAD_SLEEP);
        $deferredChargeTransaction = $this->newSecretKushki->deferredCharge($token, $amount, $months, $metadata);

        $this->assertsValidTransaction($tokenTransaction);
        $this->assertsValidApiTransaction($deferredChargeTransaction);
    }

    public function testShouldReturnSuccessfulDeferredChargeTransaction_TC_026Colombia() {
        $this->markTestSkipped('must be revisited.');

        $amount = CommonUtils::getRandomAmountColombia();
        $tokenTransaction = TokenHelper::getValidTokenTransactionColombia(self::MERCHANT_ID_COLOMBIA, $amount);
        $token = $tokenTransaction->getToken();
        $months = CommonUtils::getRandomInteger(2, 36);
        sleep(CommonUtils::THREAD_SLEEP);
        $deferredChargeTransaction = $this->newSecretKushkiColombia->deferredCharge($token, $amount, $months);
        $this->assertsValidTransaction($tokenTransaction);
        $this->assertsValidApiTransaction($deferredChargeTransaction);
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

    private function assertsApiTransaction($transaction, $isSuccessful, $expectedMessage, $expectedCode) {
        if ($isSuccessful != $transaction->isSuccessful()) {
            print "\nIs successful? " . $transaction->isSuccessful() . " | Expected: " . $isSuccessful;
            print "\nResponse text: " . $transaction->getResponseText() . " | Expected: " . $expectedMessage;
            print "\nResponse code: " . $transaction->getResponseCode() . " | Expected: " . $expectedCode;
            print "\n";
        }
        if($isSuccessful)
        $this->assertEquals($isSuccessful, $transaction->isSuccessful());
        else {
            $this->assertEquals($isSuccessful, $transaction->isSuccessful());
            $this->assertEquals($expectedMessage, $transaction->getResponseText());
            $this->assertEquals($expectedCode, $transaction->getResponseCode());
        }
    }

    private function assertsValidTransaction($transaction) {
        $this->assertsTransaction($transaction, true, "Transacción aprobada", "000");
    }

    private function assertsValidApiTransaction($transaction) {
        $this->assertsApiTransaction($transaction, true, "Transacción aprobada", "000");
    }

    public function getSubscriptionId($colombiaMerchant = false){
        $type = "subscription-token";
        if($colombiaMerchant){
            $amount = CommonUtils::getRandomAmountColombia();
            $tokenSubscription = TokenHelper::getValidTokenTransactionColombia(self::MERCHANT_ID_COLOMBIA, $amount, $type);
        }
        else{
            $amount = CommonUtils::getRandomAmount();
            $tokenSubscription = TokenHelper::getValidTokenTransaction(self::MERCHANT_ID, $amount, $type);
        }
        $token = $tokenSubscription->getToken();
        $planName = "Premium";
        $periodicity = "monthly";
        $contactDetails = array(
            "firstName" => "Lisbeth",
            "lastName" => "Salander",
            "email" => "lisbeth@salander.com");
        $startDate = "2017-01-18";
        sleep(CommonUtils::THREAD_SLEEP);
        $createSubscription = $this->newSecretKushki->createSubscription($token, $planName, $periodicity,
            $contactDetails, $amount, $startDate);
        return $createSubscription->getSubscriptionId();
    }
}
