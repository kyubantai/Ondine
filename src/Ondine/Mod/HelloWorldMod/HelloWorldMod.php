<?php

namespace Ondine\Mod;

use Ondine;
use Ondine\Engine;
use Ondine\IO\JSONResponse;

class HelloWorldMod extends Ondine\ModController
{
    /**
     * Called after building controller
     * @param string $format Format used for responses
     */
    public function init($format = Engine::FORMAT_JSON)
    {
        // TODO: Implement init() method.
    }

    /**
     * Called when Engine wait a response
     * @return \Ondine\IO\Response
     */
    public function response()
    {
        return new JSONResponse('Hello you!');
    }
}