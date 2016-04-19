<?php

namespace kushki\tests\inttests\lib;

use kushki\lib\RequestHandler;

class TokenRequestHandler extends RequestHandler
{

    public function __construct($request)
    {
        parent::__construct($request);
    }

    public function requestToken()
    {
        $response = $this->call();
        return $response;
    }

}

?>
