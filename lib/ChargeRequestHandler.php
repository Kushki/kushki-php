<?php

namespace kushki\lib;

class ChargeRequestHandler extends RequestHandler
{

    public function __construct($request)//$CurlHandler)
    {
        parent::__construct($request);//$CurlHandler);
    }

    public function charge()
    {
        $response = $this->call();
        return $response;
    }

}

?>
