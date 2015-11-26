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

    public function isSuccessful(){
        return $this->responseCode === 200;
    }

    public function getTicketNumber(){
        return $this->body->ticket_number;
    }

    public function getResponseText(){
        return $this->body->response_text;
    }
}

?>
