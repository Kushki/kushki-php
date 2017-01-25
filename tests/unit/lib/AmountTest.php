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
            "Subtotal_IVA" => '0.10',
            "Subtotal_IVA0" => '0.10',
            "IVA" => '0.10',
            "ICE" => '0.10',
            "Total_amount" => '0.40'
        );
        $this->assertEquals($result, $expectedResult, "Amount not correctly transformed to hash");
    }

    public function testTransformsToHashColombia() {
        $extraTaxes = new ExtraTaxes(100, 0, 0, 0);
        $amount = new Amount(3200.0, 608.0, 0.0, $extraTaxes);
        $result = $amount->toHash();
        $expectedResultTaxes = array(
                            "0" => array(
                                        "taxId" => '3',
                                        "taxAmount" => '100',
                                        "taxName" => 'PROPINA'));
        $expectedResult = array(
            "Subtotal_IVA" => '3200.00',
            "Subtotal_IVA0" => '0.00',
            "IVA" => '608.00',
            "Total_amount" => '3908.00',
            "tax" => $expectedResultTaxes
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
            "Subtotal_IVA" => $subtotalIVA,
            "Subtotal_IVA0" => $subtotalIVA0,
            "IVA" => $iva,
            "ICE" => $ice,
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
            "0" => array(
                "taxId" => '3',
                "taxAmount" => Validations::validateNumber($propina, 0, 12, ""),
                "taxName" => 'PROPINA'),
            "1" => array(
                "taxId" => '4',
                "taxAmount" => Validations::validateNumber($tasaAeroportuaria, 0, 12, ""),
                "taxName" => 'TASA_AERO'),
            "2" => array(
                "taxId" => '5',
                "taxAmount" => Validations::validateNumber($agenciaDeViajes, 0, 12, ""),
                "taxName" => 'TASA_ADMIN_AGEN_COD'),
            "3" => array(
                "taxId" => '6',
                "taxAmount" => Validations::validateNumber($iac, 0, 12, ""),
                "taxName" => 'IAC'));

        $expectedResult = array(
            "Subtotal_IVA" => Validations::validateNumber($subtotalIVA, 0, 12, ""),
            "Subtotal_IVA0" => Validations::validateNumber($subtotalIVA0, 0, 12, ""),
            "IVA" => Validations::validateNumber($iva, 0, 12, ""),
            "Total_amount" => Validations::validateNumber($total, 0, 12, ""),
            "tax" => $expectedResultTaxes
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
