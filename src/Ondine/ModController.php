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
     */
    public abstract function init($format = Engine::FORMAT_JSON);

    /**
     * Called when Engine wait a response
     * @return \Ondine\IO\Response
     */
    public abstract function response();

} 