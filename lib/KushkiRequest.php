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

}

?>
