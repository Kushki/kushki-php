<?php
namespace kushki\tests\unit\lib;

use kushki\tests\lib\CommonUtils;
use kushki\lib\Amount;
use PHPUnit_Framework_TestCase;

require_once dirname(__FILE__) . '/../../lib/CommonUtils.php';

class AmountTest extends PHPUnit_Framework_TestCase {

  public function testTransformsToHash() {
      $amount = new Amount(0.1, 0.1, 0.1, 0.1, 0.1);
      $result = $amount->toHash();
      $expectedResult = array(
          "Subtotal_IVA" => 0.1,
          "Subtotal_IVA0" => 0.1,
          "Subtotal_ICE" => 0.1,
          "IVA" => 0.1,
          "ICE" => 0.1,
          "Total_amount" => 0.5
      );

      $this->assertEquals($result, $expectedResult, "Amount not correctly transformed to hash");
  }

  public function testTransformsToHashWithValidInputs() {
      $subtotalIVA = CommonUtils::getRandomDouble(1, 50);
      $subtotalIVA0 = CommonUtils::getRandomDouble(1, 50);
      $subtotalICE = CommonUtils::getRandomDouble(1, 50);
      $iva = CommonUtils::getRandomDouble(1, 50);
      $ice = CommonUtils::getRandomDouble(1, 50);
      $total = $subtotalIVA + $subtotalIVA0 + $subtotalICE + $iva + $ice;

      $amount = new Amount($subtotalIVA, $iva, $subtotalIVA0, $subtotalICE, $ice);
      $result = $amount->toHash();
      $expectedResult = array(
          "Subtotal_IVA" => $subtotalIVA,
          "Subtotal_IVA0" => $subtotalIVA0,
          "Subtotal_ICE" => $subtotalICE,
          "IVA" => $iva,
          "ICE" => $ice,
          "Total_amount" => $total
      );

      $this->assertEquals($result, $expectedResult, "Amount not correctly transformed to hash");
  }

    public function testThrowsKushkiExceptionIfAmountIsInvalidDataProvider() {
        $invalidSubtotalIVA = new Amount(-2, 0, 0, 0, 0);
        $invalidIva = new Amount(0, -2, 0, 0, 0);
        $invalidSubtotalIVA0 = new Amount(0, 0, -2, 0, 0);
        $invalidSubtotalICE = new Amount(0, 0, 0, -2, 0);
        $invalidIce = new Amount(0, 0, 0, 0, -2);
        $invalidAmountsAndExceptionMessages = array(
            array($invalidSubtotalIVA, "El subtotal IVA debe ser superior o igual a 0"),
            // array($invalidSubtotalIVA0, "El subtotal IVA 0 debe ser superior o igual a 0"),
            // array($invalidSubtotalICE, "El subtotal ICE debe ser superior o igual a 0"),
            // array($invalidIva, "El IVA debe ser superior o igual a 0"),
            // array($invalidIce, "El ICE debe ser superior o igual a 0"),
        );
        return $invalidAmountsAndExceptionMessages;
    }

    /**
     * @dataProvider testThrowsKushkiExceptionIfAmountIsInvalidDataProvider
     */
    public function testThrowsKushkiExceptionIfAmountIsInvalid($amount, $exceptionMessage) {
        $this->setExpectedException('kushki\lib\KushkiException', $exceptionMessage, 0);
        $amount->toHash();
    }
}
