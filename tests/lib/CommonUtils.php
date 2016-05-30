<?php
namespace kushki\tests\lib;
use kushki\lib\Amount;

class CommonUtils {

    const ALPHA_NUMBER_CHARACTERS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const ALPHA_CHARACTERS = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const NUMBER_CHARACTERS = '0123456789';

    const THREAD_SLEEP = 1;

    static function randomAlphaNumberString($minSize = 1, $maxSize = 10) {
        return self::randomString(self::ALPHA_NUMBER_CHARACTERS, $minSize, $maxSize);
    }

    static function randomAlphaString($minSize = 1, $maxSize = 10) {
        return self::randomString(self::ALPHA_CHARACTERS, $minSize, $maxSize);
    }

    static function randomNumberString($minSize = 1, $maxSize = 10) {
        return self::randomString(self::NUMBER_CHARACTERS, $minSize, $maxSize);
    }

    static function randomString($alphabet, $minSize = 1, $maxSize = 10) {
        $randstring = '';
        for ($i = $minSize; $i <= $maxSize; $i++) {
            $randstring = $alphabet[rand(0, strlen($alphabet) - 1)];
        }
        return $randstring;
    }

    static function getRandomDouble($min, $max) {
      $randomInt = rand($min*100, $max*100);
      $randomDouble = $randomInt / 100;
      return $randomDouble;
    }

    static function getRandomAmount() {
        return new Amount(1, 1, 1, 1);
    }

    static function getRandomDoubleAmount($valid = true) {
        $validCents = [0.0, 0.08, 0.11, 0.59, 0.6];
        $invalidCents = [0.05, 0.1, 0.21, 0.61, 0.62, 0.63];

        if ($valid) {
            $centPosition = rand(0, sizeof($validCents) - 1);
            $cents = $validCents[$centPosition];
        } else {
            $centPosition = rand(0, sizeof($invalidCents) - 1);
            $cents = $invalidCents[$centPosition];
        }
        return rand(1, 9999) + $cents;
    }

}
