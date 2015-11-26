<?php

namespace kushki\lib;

use kushki\lib\KushkiConstant;

class KushkiRequest
{

    protected $url = "";
    protected $params = array();
    protected $contentType = "";

    public function __construct($url, $params = array(),
                                $contentType = KushkiConstant::CONTENT_TYPE)
    {
        $this->url = $url;
        $this->params = $params;
        $this->contentType = $contentType;
    }

    public function getParameter($parameterName)
    {
        if (isset($this->params[$parameterName])) {
            return $this->params[$parameterName];
        }
        throw new KushkiException(KushkiConstant::PARAMETER_DO_NOT_EXIST);
    }

    public function getContentType()
    {
        return $this->contentType;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getBody(){
        return $this->getEncryptBody();
    }

    private function getPlainBody(){
        return json_encode($this->getParams());
    }

    private function getEncryptBody(){
        $contentToEncrypt = $this->getPlainBody();
        $contentEncrypted = "";
        $encryptResult = openssl_public_encrypt($contentToEncrypt, $contentEncrypted, KushkiConstant::KUSHKI_PUBLIC_KEY);
        if ($encryptResult === true){
            $responseEncripted = array();
            $responseEncripted['request'] = $contentEncrypted;
            return json_encode($responseEncripted);
        }
        throw new KushkiException("Error encrypting with the public key");
    }

}

?>
