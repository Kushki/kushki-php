<?php

namespace kushki\lib;

class RequestHandler
{

    protected $request;
    protected $CurlHandler;

    public function __construct($CurlHandler)
    {
        $this->CurlHandler = $CurlHandler;
    }

}

?>
