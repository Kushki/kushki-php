<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 3/20/17
 * Time: 3:25 PM
 */

namespace kushki\tests\unit\lib;

use kushki\lib\KushkiSubscriptionRequest;
use kushki\lib\KushkiCurrency;
use kushki\tests\lib\CommonUtils;
use PHPUnit_Framework_TestCase;

require_once dirname(__FILE__) . '/../../lib/CommonUtils.php';

class KushkiSubscriptionRequestTest extends PHPUnit_Framework_TestCase{
    private $request;
    private $environment;
    private $randomMerchantId;
    private $currency = KushkiCurrency::USD;
    private $randomTransactionAmount;
    private $randomTransactionToken;
    private $planName;
    private $periodicity;
    private $conctactDetails;
    private $starDate;

    public function testHasTokenOnChargeRequest() {
        $this->createSubscriptionRequest();
        $this->assertEquals($this->randomTransactionToken,
            $this->request->getParameter("token"),
            "Requires param token");
    }

    public function testHasAmountOnCreateSubscriptionRequest() {
        $this->createSubscriptionRequest();
        $amount = $this->randomTransactionAmount->toHash();
        $amount["currency"] = "USD";
        $this->assertEquals($amount,
            $this->request->getParameter("amount"),
            "Requires param amount");
    }

    public function testHasAmountOnCreateSubscriptionRequestColombia() {
        $this->createSubscriptionRequest(true);
        $amount = $this->randomTransactionAmount->toHash();
        $amount["currency"] = "COP";
        $this->assertEquals($amount,
            $this->request->getParameter("amount"),
            "Requires param amount");
    }

    public function testHasPlanNameOnCreateSubscriptionRequest() {
        $this->createSubscriptionRequest();
        $this->assertEquals($this->planName,
            $this->request->getParameter("planName"),
            "Requires param planName");
    }

    public function testHasPeriodicityOnCreateSubscriptionRequestColombia() {
        $this->createSubscriptionRequest();
        $this->assertEquals($this->periodicity,
            $this->request->getParameter("periodicity"),
            "Requires param periodicity");
    }

    public function testHasContactDetailsOnCreateSubscriptionRequestColombia() {
        $this->createSubscriptionRequest();
        $this->assertEquals($this->conctactDetails,
            $this->request->getParameter("contactDetails"),
            "Requires param contactDetails");
    }

    public function testHasStartDateOnCreateSubscriptionRequestColombia() {
        $this->createSubscriptionRequest();
        $this->assertEquals($this->starDate,
            $this->request->getParameter("startDate"),
            "Requires param startDate");
    }

    private function createSubscriptionRequest($isColombianTransaction = false) {
        $this->environment = CommonUtils::randomAlphaNumberString();
        $this->randomMerchantId = CommonUtils::randomAlphaNumberString();
        $this->randomTransactionToken = CommonUtils::randomAlphaNumberString();
        $this->planName = CommonUtils::randomAlphaNumberString();
        $this->periodicity = CommonUtils::randomAlphaNumberString();
        $this->conctactDetails =  array("firstName" => "Lisbeth",
                                        "lastName" => "Salander",
                                        "email" => "lisbeth@salander.com");
        $this->starDate = "2017-01-18";
        if($isColombianTransaction) {
            $this->randomTransactionAmount = CommonUtils::getRandomAmountColombia();
            $this->currency = KushkiCurrency::COP;
        } else {
            $this->randomTransactionAmount = CommonUtils::getRandomAmount();
        }
        $this->request = new KushkiSubscriptionRequest($this->randomMerchantId, $this->randomTransactionToken,
            $this->planName, $this->periodicity, $this->conctactDetails, $this->randomTransactionAmount,
            $this->starDate, $metadata = false, $this->environment, $this->currency);
    }
}