<?php

namespace Ondine\IO;

class HTMLResponse extends Response
{
    public function __construct($content)
    {
        parent::__construct($content);
    }

    /**
     * Display the response
     * @param bool $header Must send content-type header
     */
    function display($header = false)
    {
        if ($header)
        {
            header('Content-Type: text/html');
        }

        print $this->getContent();
    }

}