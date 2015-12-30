<?php

namespace kushki\lib;

class RefundRequestHandler extends RequestHandler {

    public function __construct($request) {
        parent::__construct($request);
    }

    public function refundCharge() {
        $response = $this->call();
        return $response;
    }
}

?>
