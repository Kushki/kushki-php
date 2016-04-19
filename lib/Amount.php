<?php

namespace kushki\lib;

class Amount {

    private $subtotalIVA;
    private $subtotalIVA0;
    private $subtotalICE;
    private $iva;
    private $ice;

    public function __construct($subtotalIVA, $iva, $subtotalIVA0, $subtotalICE, $ice) {
        $this->subtotalIVA = $subtotalIVA;
        $this->subtotalIVA0 = $subtotalIVA0;
        $this->subtotalICE = $subtotalICE;
        $this->iva = $iva;
        $this->ice = $ice;
    }

    public function toHash() {

        $validatedSubtotalIVA = Validations::validateNumber($this->subtotalIVA, 0, 12, "El subtotal IVA");
        $validatedSubtotalIVA0 = Validations::validateNumber($this->subtotalIVA0, 0, 12, "El subtotal IVA 0");
        $validatedSubtotalICE = Validations::validateNumber($this->subtotalICE, 0, 12, "El subtotal ICE");
        $validatedIva = Validations::validateNumber($this->iva, 0, 12, "El IVA");
        $validatedIce = Validations::validateNumber($this->ice, 0, 12, "El ICE");

        $total = $this->subtotalIVA + $this->subtotalIVA0 + $this->subtotalICE + $this->iva + $this->ice;
        $validatedTotal = Validations::validateNumber($total, 0, 12, "El total");

        return array(
            "Subtotal_IVA" => $validatedSubtotalIVA,
            "Subtotal_IVA0" => $validatedSubtotalIVA0,
            "Subtotal_ICE" => $validatedSubtotalICE,
            "IVA" => $validatedIva,
            "ICE" => $validatedIce,
            "Total_amount" => $validatedTotal
        );
    }

    public function toString() {
        return "sI: " . $this->subtotalIVA . " sI0: " . $this->subtotalIVA0 . " sC: " . $this->subtotalICE .
               " I: " . $this->iva . " C: " . $this->ice;
    }
}
