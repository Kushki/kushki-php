<?php
namespace kushki\tests\unit\lib;

use kushki\app\lib\kushki;

class KushkiTest extends \PHPUnit_Framework_TestCase {
    public function testHasMerchantId() {
        $merchantId = rand( 1000, 10000);
        $api = new Kushki($merchantId);

        $this->assertEquals($merchantId, $api->getMerchantId());
    }
}
