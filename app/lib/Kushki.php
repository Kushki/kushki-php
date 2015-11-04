<?php

namespace kushki\app\lib;

class Kushki {
  const VERSION = '0.0.1';
  const FORCE_TO_USE_SSL = false;

  private $apiUrl = "https://kushki-api.herokuapp.com/v1/charge";
  private $merchantId;

  public function __construct($merchantId){
    $this->merchantId = $merchantId;
  }

  public function charge($token, $amount, $currency){

  }

  public function getMerchantId(){
    return $this->merchantId;
  }

}

?>
