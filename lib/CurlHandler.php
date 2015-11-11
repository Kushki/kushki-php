<?php
namespace kushki\lib;

use kushki\lib\Response;

class CurlHandler
{

    private function getParameters($request)
    {
        $parameters = json_encode($request->getParams());
        return $parameters;
    }

    private function prepareCurl(&$curl, $url, $contentType, $postFields)
    {
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($curl, CURLOPT_URL, $url); // .'/api/index.php'
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array($contentType));
    }

    public function call($request)
    {
        $parameters = $this->getParameters($request);

        $curl = curl_init();
        $this->prepareCurl($curl, $request->getUrl(), $request->getContentType(), $parameters);
        $response = curl_exec($curl);
        $contentType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
        $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $response = new Response($contentType, $response, $responseCode);
        curl_close($curl);

        return $response;
    }

}

?>
