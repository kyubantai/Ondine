<?php

class EngineTest extends PHPUnit_Framework_TestCase
{
    private static $path;
    private static $default;

    public static function setUpBeforeClass()
    {
        self::$path = __DIR__ . '/dictionary.json';
        if (!file_put_contents(self::$path, '{ "mod": [ {"word": "1"} ]}'))
        {
            throw new Exception();
        }

        self::$default = [
            'dictionary'    => self::$path,
            'mods'          => __DIR__ . '/Mod',
            'format'        => 'html'
        ];
    }

    public static function tearDownAfterClass()
    {
        if (!unlink(self::$path))
        {
            throw new Exception();
        }
    }

    public function testSetup()
    {
        // Send a string instead of an array
        // as config for the engine
        try
        {
            \Ondine\Engine::setup('test');
            $this->fail('Should crash');
        }
        catch (InvalidArgumentException $e) {}


        // Check if custom config is well applied
        \Ondine\Engine::setup(self::$default);
        $config = \Ondine\Engine::getConfig();
        $this->assertEquals($config, self::$default);
    }

    public function testAsk()
    {
        // Call ask with no parameter
        try {
            \Ondine\Engine::setup(self::$default);
            $engine = \Ondine\Engine::getInstance();
            $engine->ask();

            $this->fail('Should crash');
        }
        catch(InvalidArgumentException $e) {}
    }
} 