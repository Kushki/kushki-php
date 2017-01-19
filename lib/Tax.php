<?php
/**
 * Created by PhpStorm.
 * User: acabrera
 * Date: 18/01/17
 * Time: 14:58
 */

namespace kushki\lib;


class Tax
{
    const NULL = null;

    private $propina;
    private $tasaAeroportuaria;
    private $agenciaDeViajes;
    private $iac;

    /**
     * Tax constructor.
     * @param $propina
     * @param $tasaAeroportuaria
     * @param $agenciaDeViajes
     * @param $iac
     */
    public function __construct($propina, $tasaAeroportuaria, $agenciaDeViajes, $iac)
    {
        $this->propina = $propina;
        $this->tasaAeroportuaria = $tasaAeroportuaria;
        $this->agenciaDeViajes = $agenciaDeViajes;
        $this->iac = $iac;
    }

    public function getTotalTax()
    {
        $total = $this->propina + $this->tasaAeroportuaria + $this->agenciaDeViajes + $this->iac;
        return $total;
    }

    public function toHash() {
        $validatedPropina= Validations::validateNumber($this->propina, 0, 12, "La propina");
        $validatedTasaAeroportuaria = Validations::validateNumber($this->tasaAeroportuaria, 0, 12, "La tasa aeroportuaria");
        $validatedAgenciaDeViajes = Validations::validateNumber($this->agenciaDeViajes, 0, 12, "La agencia de viajes");
        $validatedIac = Validations::validateNumber($this->iac, 0, 12, "El IAC");

        $total = $this->propina+ $this->tasaAeroportuaria + $this->agenciaDeViajes+ $this->iac;
        $validatedTotal = Validations::validateNumber($total, 0, 12, "El total");

        return array(
            "Propina" => $validatedPropina,
            "Tasa_Aeroportuaria" => $validatedTasaAeroportuaria,
            "Agencia_De_Viajes" => $validatedAgenciaDeViajes,
            "IAC" => $validatedIac,
            "Total_Tax" => $validatedTotal
        );
    }

}