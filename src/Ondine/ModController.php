<?php

namespace Ondine;

/**
 * Class ModController
 * @package Ondine
 */
abstract class ModController {

    /**
     * Called after building controller
     * @param string $format Format used for responses
     * @param array Array of keywords
     */
    public abstract function init($format = Engine::FORMAT_JSON, $keywords=[]);

    /**
     * Called when Engine wait a response
     * @return \Ondine\IO\Response
     */
    public abstract function response();

} 