<?php
namespace kushki\tests\unit\lib;

use kushki\tests\lib\CommonUtils;
use kushki\lib\Validations;
use PHPUnit_Framework_TestCase;

require_once dirname(__FILE__) . '/../../lib/CommonUtils.php';

class ValidationsTest extends PHPUnit_Framework_TestCase {
    /**
     * @dataProvider testThrowsKushkiExceptionIfNumberIsInvalidDataProvider
     */
    public function testThrowsKushkiExceptionIfNumberIsInvalid($number, $exceptionMessage) {
        $this->setExpectedException('kushki\lib\KushkiException', $exceptionMessage);
        Validations::validateNumber($number, 1, 12, "El valor");
    }

    public function testThrowsKushkiExceptionIfNumberIsInvalidDataProvider() {
        $tooLong = CommonUtils::getRandomDouble(1000000000000, 9999999999999999999);
        $negative = -CommonUtils::getRandomDouble(1, 150);
        $invalidNumbersAndExceptionMessages = array(
            array($tooLong, "El valor debe tener 12 o menos dígitos"),
            array($negative, "El valor debe ser superior o igual a 1"),
            array(0.5, "El valor debe ser superior o igual a 1"),
            array(-2, "El valor debe ser superior o igual a 1"),
            array(null, "El valor no puede ser un valor nulo")
        );
        return $invalidNumbersAndExceptionMessages;
    }
}
