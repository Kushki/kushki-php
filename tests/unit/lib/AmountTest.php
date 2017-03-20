<?php
namespace kushki\tests\unit\lib;

use kushki\lib\ExtraTaxes;
use kushki\tests\lib\CommonUtils;
use kushki\lib\Amount;
use PHPUnit_Framework_TestCase;
use kushki\lib\Validations;

require_once dirname(__FILE__) . '/../../lib/CommonUtils.php';

class AmountTest extends PHPUnit_Framework_TestCase {

    public function testTransformsToHash() {
        $amount = new Amount(0.1, 0.1, 0.1, 0.1);
        $result = $amount->toHash();
        $expectedResult = array(
            "subtotalIva" => '0.10',
            "subtotalIva0" => '0.10',
            "iva" => '0.10',
            "ice" => '0.10',
            "Total_amount" => '0.40'
        );
        $this->assertEquals($result, $expectedResult, "Amount not correctly transformed to hash");
    }

    public function testTransformsToHashColombia() {
        $extraTaxes = new ExtraTaxes(100, 0, 0, 0);
        $amount = new Amount(3200.0, 608.0, 0.0, $extraTaxes);
        $result = $amount->toHash();
        $expectedResultTaxes = array("propina" => 100);
        $expectedResult = array(
            "subtotalIva" => 3200.00,
            "subtotalIva0" => 0.00,
            "iva" => 608.00,
            "Total_amount" => '3908.00',
            "extraTaxes" => $expectedResultTaxes
        );

        $this->assertEquals($result, $expectedResult, "Amount not correctly transformed to hash");
    }

    public function testTransformsToHashWithValidInputs() {
        $subtotalIVA = CommonUtils::getRandomDouble(1, 50);
        $subtotalIVA0 = CommonUtils::getRandomDouble(1, 50);
        $iva = CommonUtils::getRandomDouble(1, 50);
        $ice = CommonUtils::getRandomDouble(1, 50);
        $total = $subtotalIVA + $subtotalIVA0 + $iva + $ice;

        $amount = new Amount($subtotalIVA, $iva, $subtotalIVA0, $ice);
        $result = $amount->toHash();
        $expectedResult = array(
            "subtotalIva" => $subtotalIVA,
            "subtotalIva0" => $subtotalIVA0,
            "iva" => $iva,
            "ice" => $ice,
            "Total_amount" => $total
        );
        $this->assertEquals($result, $expectedResult, "Amount not correctly transformed to hash");
    }

    public function testTransformsToHashWithValidInputsColombia() {
        $subtotalIVA = CommonUtils::getRandomDouble(1, 50);
        $subtotalIVA0 = CommonUtils::getRandomDouble(1, 50);
        $iva = CommonUtils::getRandomDouble(1, 50);
        $propina = CommonUtils::getRandomDouble(1,50);
        $tasaAeroportuaria = CommonUtils::getRandomDouble(1,50);
        $agenciaDeViajes = CommonUtils::getRandomDouble(1,50);
        $iac = CommonUtils::getRandomDouble(1,50);
        $extraTaxes = new ExtraTaxes($propina, $tasaAeroportuaria, $agenciaDeViajes, $iac);

        $total = $subtotalIVA + $subtotalIVA0 + $iva + $extraTaxes->getTotalExtraTaxes();

        $amount = new Amount($subtotalIVA, $iva, $subtotalIVA0, $extraTaxes);
        $result = $amount->toHash();

        $expectedResultTaxes = array(
            "propina" => Validations::validateNumber($propina, 0, 12, ""),
            "tasaAeroportuaria" => Validations::validateNumber($tasaAeroportuaria, 0, 12, ""),
            "agenciaDeViaje" => Validations::validateNumber($agenciaDeViajes, 0, 12, ""),
            "iac" => Validations::validateNumber($iac, 0, 12, ""));


        $expectedResult = array(
            "subtotalIva" => (float) Validations::validateNumber($subtotalIVA, 0, 12, ""),
            "subtotalIva0" => (float) Validations::validateNumber($subtotalIVA0, 0, 12, ""),
            "iva" => (float) Validations::validateNumber($iva, 0, 12, ""),
            "Total_amount" => Validations::validateNumber($total, 0, 12, ""),
            "extraTaxes" => $expectedResultTaxes
        );

        $this->assertEquals($result, $expectedResult, "Amount not correctly transformed to hash");
    }

    public function testThrowsKushkiExceptionIfAmountIsInvalidDataProvider() {
        $invalidSubtotalIVA = new Amount(-2, 0, 0, 0);
        $invalidIva = new Amount(0, -2, 0, 0);
        $invalidSubtotalIVA0 = new Amount(0, 0, -2, 0);
        $invalidIce = new Amount(0, 0, 0, -2);
        $invalidTax1 = new Amount(0, 0, 0, new ExtraTaxes(-2, 0, 0, 0));
        $invalidTax2 = new Amount(0, 0, 0, new ExtraTaxes(0, -2, 0, 0));
        $invalidTax3 = new Amount(0, 0, 0, new ExtraTaxes(0, 0, -2, 0));
        $invalidTax4 = new Amount(0, 0, 0, new ExtraTaxes(0, 0, 0, -2));
        $invalidAmountsAndExceptionMessages = array(
            array($invalidSubtotalIVA, "El subtotal IVA debe ser superior o igual a 0"),
            array($invalidSubtotalIVA0, "El subtotal IVA 0 debe ser superior o igual a 0"),
            array($invalidIva, "El IVA debe ser superior o igual a 0"),
            array($invalidIce, "El ICE debe ser superior o igual a 0"),
            array($invalidTax1, "El total debe ser superior o igual a 0"),
            array($invalidTax2, "El total debe ser superior o igual a 0"),
            array($invalidTax3, "El total debe ser superior o igual a 0"),
            array($invalidTax4, "El total debe ser superior o igual a 0"),
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
