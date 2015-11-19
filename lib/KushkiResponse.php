<?php

namespace kushki\lib;

class KushkiResponse
{

    protected $contentType = "";
    protected $body;
    protected $responseCode;

    public function __construct($contentType, $body, $response_code)
    {
        $this->contentType = $contentType;
        $this->body = $body;
        $this->responseCode = $response_code;
    }

    public function getContentType()
    {
        return $this->contentType;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getResponseCode()
    {
        return $this->responseCode;
    }

}

?>
