<?php

namespace Ondine;

/**
 * Class Engine
 * @package Ondine
 */
class Engine
{
    /**
     * @var Engine Engine instance
     */
    private static $instance;

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
            self::$config[$key] = (array_key_exists($key, $config)) ? $config[$key] : $value;
        }
    }

    /**
     * Create and return an instance of the Engine
     * @return Engine An instance of \Ondine\Engine
     */
    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::loadDictionary();

            self::$instance = new Engine();
        }
        return self::$instance;
    }

    /**
     * Get Engine's config
     * @return array Engine's config
     */
    public static function getConfig()
    {
        return self::$config;
    }

    private static function loadDictionary()
    {
        if (!is_file(self::$config['dictionary']))
        {
            throw new \Ondine\Exceptions\OndineException(self::$config['dictionary'] . ', no such file. Don\'t forget to generate this file!');
        }

        $json = file_get_contents(self::$config['dictionary']);

        if ($json === FALSE || empty($json))
        {
            throw new \Ondine\Exceptions\OndineException('Can\'t read file ' . self::$config['dictionary'] . ' or empty content.');
        }

        self::$dictionary = json_decode($json, true);

        if (self::$dictionary === FALSE || empty(self::$dictionary))
        {
            throw new \Ondine\Exceptions\OndineException('Can\'t convert dictionary from JSON to Array');
        }
    }
} 