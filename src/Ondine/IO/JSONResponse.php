<?php

namespace Ondine\IO;

class JSONResponse extends Response
{
    public function __construct($content, $status=Response::STATUS_SUCCESS)
    {
        parent::__construct($content, $status);
    }

    /**
     * Display the response
     * @param bool $header Must send content-type header
     */
    function display($header = false)
    {

        $array = [
            'content' => $this->getContent()
        ];

        $json = json_encode($array, JSON_PRETTY_PRINT);

        header('Content-Type: application/json');
        http_response_code(self::statusToCode($this->getStatus()));
        print $json;
    }

} 