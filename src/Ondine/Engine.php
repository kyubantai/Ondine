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
    private static $format = self::FORMAT_JSON;



    /**
     * @var \Ondine\Process Object containing all data of this execution
     */
    private $process;



    private function __construct()
    {
        // Start new process
        $this->process = new Process();
    }

    /**
     * Ask the specified question and return an answer
     * @param string $string Question for Ondine
     * @throws OndineException
     */
    public function ask($string = self::NO_STRING)
    {
        if ($string === self::NO_STRING || !is_string($string))
        {
            throw new OndineException('Missing or empty parameter String');
        }

        $this->process->setQuestion($string);

        $string = self::sanitize($string);
        $stringArray = self::toArray($string);

        $this->handleWords($stringArray);

        $mod = $this->getRelatedMod();

        if ($mod == null)
        {
            $this->process->setResponse(null); //TODO:
            return;
        }

        $path = self::$config['mods'] . $mod . '/' . $mod . '.php';
        if (!is_file($path))
        {
            throw new OndineException('Invalid mod name/directory');
        }

        require $path;

        if (!class_exists($mod))
        {
            throw new OndineException('Invalid mod name/class association');
        }

        $modInstance = new $mod;
        if ($modInstance instanceof ModController)
        {
            $modInstance->init(self::$format); //TODO:
            $this->process->stop($modInstance->response());
        }
        else
        {
            throw new OndineException('Main mod class does not extend the ModController class');
        }
    }

    /**
     * Display engine response.
     * @param bool $header (Optional) Set to TRUE if you want to declare automatically headers
     * @throws OndineException
     */
    public function show($header = false)
    {
        if ($this->process->getResponse() === NULL)
        {
            throw new OndineException('No response ready');
        }

        // All is done, save the process in logs
        $this->process->save();

        $this->process->getResponse()->display($header);
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

    /**
     * Sanitize a string
     * @param string $text String to sanitize
     * @return string The sanitized string
     */
    public static function sanitize($text)
    {
        $text = strtolower($text);

        // Other things may come here later

        return $text;
    }

    /**
     * Explode the string (keeping only words)
     * @param string $string The string to convert in an array
     * @return array
     */
    public static function toArray($string)
    {
        $array = preg_split("/[\s,\!\?\.\:]+/", $string);

        // Remove empty values
        $array = array_filter($array);

        return $array;
    }

    /**
     * Scan mod's weight for each word
     * @param array $words Array of words
     * @throws OndineException
     */
    public function handleWords($words)
    {
        if (!is_array($words))
        {
            throw new OndineException('Expected parameter to be an array');
        }

        foreach($words as $word)
        {
            $this->scanWordWeight($word);
        }
    }

    /**
     * Search weight of a word in each mod and add it to the table
     * @param string $word Word to scan
     * @throws OndineException
     */
    public function scanWordWeight($word)
    {
        if (self::$dictionary == null || !is_array(self::$dictionary))
        {
            throw new OndineException('Dictionary not loadded');
        }

        if ($word == null || empty($word))
        {
            throw new OndineException('Supplied word is null or empty');
        }

        foreach(self::$dictionary as $mod => $dictionary)
        {
            if (array_key_exists($word, $dictionary))
            {
                $this->process->addWeightTo($mod, $dictionary[$word]);
            }
        }
    }

    /**
     * Gets mod's name with the best matching
     * @return string Name of the mod
     */
    public function getRelatedMod()
    {
        $array = $this->process->getWeightArray();
        if (count($array) == 0)
        {
            return null;
        }

        list($first, $rest) = array_keys($array);

        return $first;
    }
}