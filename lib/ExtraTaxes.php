<?php

namespace kushki\lib;

use phpDocumentor\Reflection\Types\Array_;

class ExtraTaxes
{
    const NULL = null;

    const ID_TAX_PROPINA = "3";
    const ID_TAX_AERO = "4";
    const ID_TAX_AGEN = "5";
    const ID_TAX_IAC = "6";

    const NAME_TAX_PROPINA = "PROPINA";
    const NAME_TAX_AERO = "TASA_AERO";
    const NAME_TAX_AGEN = "TASA_ADMIN_AGEN_COD";
    const NAME_TAX_IAC = "IAC";

    private $propina;
    private $tasaAeroportuaria;
    private $agenciaDeViajes;
    private $iac;

    /**
     * ExtraTaxes constructor.
     * @param $propina
     * @param $tasaAeroportuaria
     * @param $agenciaDeViajes
     * @param $iac
     */
    public function __construct($propina, $tasaAeroportuaria, $agenciaDeViajes, $iac)
    {
        $this->propina = new Tax(ExtraTaxes::ID_TAX_PROPINA, ExtraTaxes::NAME_TAX_PROPINA, $propina);
        $this->tasaAeroportuaria = new Tax(ExtraTaxes::ID_TAX_AERO, ExtraTaxes::NAME_TAX_AERO, $tasaAeroportuaria);
        $this->agenciaDeViajes = new Tax(ExtraTaxes::ID_TAX_AGEN, ExtraTaxes::NAME_TAX_AGEN, $agenciaDeViajes);
        $this->iac = new Tax(ExtraTaxes::ID_TAX_IAC, ExtraTaxes::NAME_TAX_IAC, $iac);
    }

    public function getTotalExtraTaxes()
    {
        $total = $this->propina->getAmount() + $this->tasaAeroportuaria->getAmount() +
                 $this->agenciaDeViajes->getAmount() + $this->iac->getAmount();
        return $total;
    }

    public function toHashArray() {
        $extraTaxes = array();
        if($this->propina->getAmount() > 0) {
            $extraTaxes[0] = $this->propina->toHash();
        }
        if($this->tasaAeroportuaria->getAmount() > 0) {
            $extraTaxes[1] = $this->tasaAeroportuaria->toHash();
        }
        if($this->agenciaDeViajes->getAmount() > 0) {
            $extraTaxes[2] = $this->agenciaDeViajes->toHash();
        }
        if($this->iac->getAmount() > 0) {
            $extraTaxes[3] = $this->iac->toHash();
        }
        return array_values($extraTaxes);
    }
}