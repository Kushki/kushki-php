<?php

namespace kushki\lib;

class VoidRequestHandler extends RequestHandler {

    public function __construct($request) {
        parent::__construct($request);
    }

    public function voidCharge() {
        $response = $this->call();
        return $response;
    }
}

?>
