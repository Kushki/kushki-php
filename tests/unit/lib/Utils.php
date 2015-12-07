<?php
namespace kushki\tests\unit\lib;

use PHPUnit_Framework_TestCase;

class Utils extends PHPUnit_Framework_TestCase
{

    const ALPHA_NUMBER_CHARACTERS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const ALPHA_CHARACTERS = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    static function randomAlphaNumberString($minSize = 1, $maxSize = 10)
    {
        return self::randomString(self::ALPHA_NUMBER_CHARACTERS, $minSize, $maxSize);
    }

    static function randomAlphaString($minSize = 1, $maxSize = 10)
    {
        return self::randomString(self::ALPHA_CHARACTERS, $minSize, $maxSize);
    }

    static function randomString($alphabet, $minSize = 1, $maxSize = 10)
    {
        $randstring = '';
        for ($i = $minSize; $i <= $maxSize; $i++) {
            $randstring = $alphabet[rand(0, strlen($alphabet) - 1)];
        }
        return $randstring;
    }

}
