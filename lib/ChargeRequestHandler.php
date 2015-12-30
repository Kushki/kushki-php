<?php

namespace kushki\lib;

class ChargeRequestHandler extends RequestHandler {

    public function __construct($request) {
        parent::__construct($request);
    }

    public function charge() {
        $response = $this->call();
        return $response;
    }
}

?>
