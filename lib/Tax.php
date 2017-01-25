<?php

namespace kushki\lib;

class Tax
{
    private $taxId;
    private $taxName;
    private $taxAmount;

    /**
     * Tax constructor.
     * @param $taxId
     * @param $taxAmount
     * @param $taxName
     */
    public function __construct($taxId, $taxName, $taxAmount)
    {
        $this->taxId = $taxId;
        $this->taxAmount = $taxAmount;
        $this->taxName = $taxName;
    }

    public function toHash() {
        $validatedAmount = Validations::validateNumber($this->taxAmount, 0, 12, "Amount");
        return array(
            "taxId" => $this->taxId,
            "taxAmount" => $validatedAmount,
            "taxName" => $this->taxName
        );
    }

    public function getAmount() {
        return $this->taxAmount;
    }
}
