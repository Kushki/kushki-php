<?php
namespace kushki\lib;

use Httpful\Httpful;

class RequestHandler
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    protected function call(){
        $requestBody = $this->request->getBody();
        $responseRaw = \Httpful\Request::post($this->request->getUrl())
            ->contentType($this->request->getContentType())
            ->withStrictSSL()
            ->body($requestBody)
            ->send();

        $response = new KushkiResponse($responseRaw->content_type, $responseRaw->body, $responseRaw->code);

        return $response;
    }

}

?>
