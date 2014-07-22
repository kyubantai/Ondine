<?php

namespace Ondine;

/**
 * Class Engine
 * @package Ondine
 */
class Engine
{
    /**
     * @const NO_STRING Used to describe a null string parameter
     */
    const NO_STRING = 'NO_STRING';

    /**
     * @var array $config Engine's config
     */
    private static $config;

    /**
     * @var object $dictionary Contains the dictionary tree
     */
    private static $dictionary;

    private function __construct()
    {
        //TODO:
    }

    /**
     * Ask the specified question and return an answer
     * @param string $string Question for Ondine
     * @throws \InvalidArgumentException
     * @return
     */
    public function ask($string = self::NO_STRING)
    {
        if ($string === self::NO_STRING)
        {
            throw new \InvalidArgumentException('Missing or empty parameter String');
        }
        
        //TODO:

        return null;
    }

    /**
     * Init the engine
     * @param array $config (optionnal) Engine's config
     * @throws \InvalidArgumentException
     */
    public static function setup($config = [])
    {
        if (!is_array($config))
        {
            throw new \InvalidArgumentException('Config must be an array');
        }

        $default = [
            'dictionary'    => __DIR__ . '/../../res/dictionary.json',
            'mods'          => __DIR__ . '/Mod/'
        ];

        foreach($default as $key => $value)
        {
            self::$config[$key] = $config[$key] | $value;
        }
    }

    /**
     * Create and return an instance of the Engine
     * @return Engine An instance of \Ondine\Engine
     */
    public static function getInstance()
    {
        $engine = new Engine();

        //TODO:

        return $engine;
    }

} 