<?php

use kushki\lib\Kushki;
use kushki\lib\KushkiCurrencies;
use kushki\lib\KushkiLanguages;

include_once("autoload.php");

$merchantId = "10000000123454545454546546";
$idioma = KushkiLanguages::ES;
$moneda = KushkiCurrencies::USD;
$kushki = new Kushki($merchantId, $idioma, $moneda);
$token = "s25s784a87ad497af797a48sdg7rhy4d";
$monto = 100.45;
$transaction = $kushki->charge($token, $monto);

if ($transaction->isSuccessful()) {
    echo "Número de ticket: " . $transaction->getTicketNumber();
} else {
    echo "Mensaje de error: " . $transaction->getResponseText();
}