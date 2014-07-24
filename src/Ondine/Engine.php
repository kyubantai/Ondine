<?php

namespace Ondine;
use Ondine\Exceptions\OndineException;

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
     * @const FORMAT_HTML HTML format used to return data
     */
    const FORMAT_HTML = "html";

    /**
     * @const FORMAT_XML XML format used to return data
     */
    const FORMAT_XML = "xml";

    /**
     * @const FORMAT_JSON JSON format used to return data
     */
    const FORMAT_JSON = "json";

    /**
     * @const FORMAT_TEXT Format used to return data
     */
    const FORMAT_TEXT = "text";


    /**
     * @var Engine Engine instance
     */
    private static $instance;

    /**
     * @var array $config Engine's config
     */
    private static $config;

    /**
     * @var object $dictionary Contains the dictionary tree
     */
    private static $dictionary;

    /**
     * @var string $format Response format
     */
    private static $format = self::FORMAT_HTML;



    /**
     * @var \Ondine\IO\Response Response from module
     */
    private $response = null;



    private function __construct()
    {
        //TODO:
    }

    /**
     * Ask the specified question and return an answer
     * @param string $string Question for Ondine
     * @throws \InvalidArgumentException
     */
    public function ask($string = self::NO_STRING)
    {
        if ($string === self::NO_STRING || !is_string($string))
        {
            throw new \InvalidArgumentException('Missing or empty parameter String');
        }
        
        //TODO:
    }

    /**
     * Display engine response.
     * @param bool $header (Optionnal) Set to TRUE if you want to declare automatically headers
     * @throws Exceptions\OndineException
     */
    public function show($header = false)
    {
        if ($this->response === NULL)
        {
            throw new OndineException('No response ready');
        }

        $this->response->display($header);
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
            'mods'          => __DIR__ . '/Mod/',
            'format'        => self::FORMAT_JSON
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

    /**
     * Load the dictionary from the JSON generated file
     * @throws Exceptions\OndineException
     */
    private static function loadDictionary()
    {
        if (!is_file(self::$config['dictionary']))
        {
            throw new OndineException(self::$config['dictionary'] . ', no such file. Don\'t forget to generate this file!');
        }

        $json = file_get_contents(self::$config['dictionary']);

        if ($json === FALSE || empty($json))
        {
            throw new OndineException('Can\'t read file ' . self::$config['dictionary'] . ' or empty content.');
        }

        self::$dictionary = json_decode($json, true);

        if (self::$dictionary === FALSE || empty(self::$dictionary))
        {
            throw new OndineException('Can\'t convert dictionary from JSON to Array');
        }
    }
} 