<?php

namespace Ondine\Mod\HelloWorldMod;

use Ondine\Engine;

class HelloWorldController extends \Ondine\ModController
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
        // TODO: Implement response() method.
    }

}