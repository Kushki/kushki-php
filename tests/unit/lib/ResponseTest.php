<?php
namespace kushki\tests\unit\lib;

use kushki\lib\kushkiConstant;
use kushki\lib\KushkiResponse;
use PHPUnit_Framework_TestCase;

class ResponseTest extends PHPUnit_Framework_TestCase
{

    private $body;
    private $contentType;
    private $responseCode;
    private $response;

    private function createResponse()
    {
        $this->body = Utils::randomAlphaNumberString(20, 60);
        $this->contentType = KushkiConstant::CONTENT_TYPE;
        $this->responseCode = rand(200, 500);
        $this->response = new KushkiResponse($this->contentType, $this->body,
            $this->responseCode);
    }

    public function testMustHaveTransactionId()
    {
        $response = ResponseBuilder::createChargeOKResponse();
        $responseBody = json_decode($response->getBody());
        $this->assertObjectHasAttribute(KushkiConstant::PARAMETER_TRANSACTION_ID, $responseBody,
            "No have transaction_id");
    }

    public function testMustHaveError()
    {
        $response = ResponseBuilder::createChargeFailedResponse();
        $responseBody = json_decode($response->getBody());
        $this->assertObjectHasAttribute(KushkiConstant::PARAMETER_ERRORS, $responseBody,
            "No have error");
    }

    public function testHasBody()
    {
        $this->createResponse();
        $this->assertEquals($this->body, $this->response->getBody(),
            "Requires body");
    }

    public function testHasResponseCode()
    {
        $this->createResponse();
        $this->assertEquals($this->responseCode, $this->response->getResponseCode(),
            "Requires response code");
    }

    public function testHasContentType()
    {
        $this->createResponse();
        $this->assertEquals($this->contentType, $this->response->getContentType(),
            "Requires content type");
    }
}
