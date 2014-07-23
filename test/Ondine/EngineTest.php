<?php

class EngineTest extends PHPUnit_Framework_TestCase
{
    public function testSetup()
    {
        try
        {
            \Ondine\Engine::setup('test');
            $this->fail('Should crash');
        }
        catch (InvalidArgumentException $e) {}

        // Check if default config is applied
        $default = [
            'dictionary'    => __DIR__ . '/../../res/dictionary.json',
            'mods'          => __DIR__ . '/Mod/'
        ];
        \Ondine\Engine::setup();
        $config = \Ondine\Engine::getConfig();
        $this->assertEquals($config, $default);

        // Check if custom config is applied
        $default['dictionary'] = __DIR__ . '/dictionary.json';
        $default['mods'] = __DIR__ . '/';
        \Ondine\Engine::setup($default);
        $config = \Ondine\Engine::getConfig();
        $this->assertEquals($config, $default);
    }

    public function testAsk()
    {
        try {
            \Ondine\Engine::setup();
            $engine = \Ondine\Engine::getInstance();
            $engine->ask();

            $this->fail('Should crash');
        }
        catch(InvalidArgumentException $e) {}
    }
} 