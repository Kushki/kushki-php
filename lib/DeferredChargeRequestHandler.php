<?php

namespace kushki\lib;

class DeferredChargeRequestHandler extends RequestHandler {

    public function __construct($request) {
        parent::__construct($request);
    }

    public function deferredCharge() {
        $response = $this->call();
        return $response;
    }
}

?>
