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
        $responseRaw = \Httpful\Request::post($this->request->getUrl())
            ->contentType($this->request->getContentType())
            ->withStrictSSL()
            ->body(json_encode($this->request->getParams()))
            ->send();

        $response = new KushkiResponse($responseRaw->content_type, $responseRaw->body, $responseRaw->code);

        return $response;
    }

}

?>
