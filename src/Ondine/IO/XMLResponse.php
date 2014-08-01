<?php

namespace Ondine\IO;

class XMLResponse extends Response
{
    public function __construct($content, $status = Response::STATUS_SUCCESS)
    {
        parent::__construct($content, $status);
    }

    /**
     * Display the response
     * @param bool $header Must send content-type header
     */
    function display($header = false)
    {
        if ($header)
        {
            header('Content-Type: application/xml; charset=utf-8');
        }

        $xml  = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<response>';
        $xml .= '<status>' . $this->getStatus() . '</status>';
        $xml .= '<message><![CDATA[' . $this->getContent() . ']]></message>';
        $xml .= '</response>';

        print $xml;
    }

}