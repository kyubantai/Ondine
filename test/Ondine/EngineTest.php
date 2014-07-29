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
        catch(\Ondine\Exceptions\OndineException $e) {}
    }

    public function testSanitize()
    {
        $string1 = "this is a test";
        $sanitized = \Ondine\Engine::sanitize($string1);
        $this->assertEquals($string1, $sanitized);

        $string2 = "This Is a Test";
        $sanitized = \Ondine\Engine::sanitize($string2);
        $this->assertNotEquals($string2, $sanitized);
        $this->assertEquals($string1, $sanitized);
    }

    public function testToArray()
    {
        $string1 = "This is a simple test";
        $string2 = "This is, I think, another basic test.";
        $string3 = "Where is Bryan? I'm asking 'cause I'ven't seen him for a while...";

        $array1 = \Ondine\Engine::toArray($string1);
        $array2 = \Ondine\Engine::toArray($string2);
        $array3 = \Ondine\Engine::toArray($string3);

        $this->assertCount(5, $array1);
        $this->assertCount(7, $array2);
        $this->assertCount(12, $array3);
    }
} 