<?php

class EngineTest extends PHPUnit_Framework_TestCase
{
    public function testSetup()
    {
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
        $this->assertEquals($config, $default); //
    }
} 