<?php

namespace kushki\lib;

class ChargeRequestHandler extends RequestHandler
{

    public function __construct($CurlHandler)
    {
        parent::__construct($CurlHandler);
    }

    public function charge($request)
    {
        $response = $this->CurlHandler->call($request);
        return $response;
    }

}

?>
