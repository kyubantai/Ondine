<?php

namespace Ondine\Mod;

use Ondine;
use Ondine\Engine;
use Ondine\IO;

class HelloWorldMod extends Ondine\ModController
{
    private $format;

    /**
     * Called after building controller
     * @param string $format Format used for responses
     */
    public function init($format = Engine::FORMAT_JSON)
    {
        $this->format = $format;
    }

    /**
     * Called when Engine wait a response
     * @return \Ondine\IO\Response
     */
    public function response()
    {
        $text = 'Hello you&&&éééé"é(fs!';

        $response = null;
        switch ($this->format)
        {
            case Engine::FORMAT_HTML:
                $html = '<h1>' . $text . '</h1>';
                $response = new IO\HTMLResponse($html);
                break;
            case Engine::FORMAT_JSON:
                $response =  new IO\JSONResponse($text);
                break;
            case Engine::FORMAT_XML:
                $response = new IO\XMLResponse($text);
                break;
        }

        return $response;
    }
}