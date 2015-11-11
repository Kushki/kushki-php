<?php

namespace kushki\lib;

class TokenRequestHandler extends RequestHandler
{

    public function __construct($CurlHandler)
    {
        parent::__construct($CurlHandler);
    }

    public function getToken($request)
    {
        $response = $this->CurlHandler->call($request);
        return $response;
    }

}

?>
