<?php

namespace kushki\lib;

class Amount {

    private $subtotalIVA;
    private $subtotalIVA0;
    private $iva;
    private $ice;
    private $tax;

    public function __construct($subtotalIVA, $iva, $subtotalIVA0, $aux_tax) {
        $this->subtotalIVA = $subtotalIVA;
        $this->subtotalIVA0 = $subtotalIVA0;
        $this->iva = $iva;
        $this->ice = 0;
        $this->tax = new Tax(0, 0, 0, 0);
        if(is_numeric($aux_tax)) {
            $this->ice = $aux_tax;
        } else if($aux_tax instanceof Tax) {
            $this->tax = $aux_tax;
        }
    }

    public function toHash() {
        $validatedSubtotalIVA = Validations::validateNumber($this->subtotalIVA, 0, 12, "El subtotal IVA");
        $validatedSubtotalIVA0 = Validations::validateNumber($this->subtotalIVA0, 0, 12, "El subtotal IVA 0");
        $validatedIva = Validations::validateNumber($this->iva, 0, 12, "El IVA");
        $validatedIce = Validations::validateNumber($this->ice, 0, 12, "El ICE");
        $total_tax = Validations::validateNumber($this->tax->getTotalTax(), 0, 12, "El total tax");

        $total = $this->subtotalIVA + $this->subtotalIVA0 + $this->iva + $this->ice + $total_tax;
        $validatedTotal = Validations::validateNumber($total, 0, 12, "El total");

        return array(
            "Subtotal_IVA" => $validatedSubtotalIVA,
            "Subtotal_IVA0" => $validatedSubtotalIVA0,
            "IVA" => $validatedIva,
            "ICE" => $validatedIce,
            "Tax" => $total_tax,
            "Total_amount" => $validatedTotal
        );
    }
}
