<?php
namespace kushki\tests\unit\lib;

use kushki\lib\KushkiCurrencies;
use kushki\lib\KushkiLanguages;
use kushki\lib\Kushki;
use PHPUnit_Framework_TestCase;

class KushkiTest extends PHPUnit_Framework_TestCase {

    public function testHasMerchantId() {
        $merchantId = rand(1000, 10000);
        $api = new Kushki($merchantId, KushkiLanguages::ES, KushkiCurrencies::USD);

        $this->assertEquals($merchantId, $api->getMerchantId(), "Does not have merchant id");
    }
}
