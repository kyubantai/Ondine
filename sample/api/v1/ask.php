<?php

define('ROOT', __DIR__ . '/../../../');

require ROOT . 'vendor/autoload.php';

$default = [
    'dictionary'    => ROOT . 'res/generated/dictionary.json',
    'mods'          => ROOT . 'src/Ondine/Mod/',
    'format'        => \Ondine\Engine::FORMAT_JSON
];


if (!isset($_POST['q']) || empty($_POST['q']))
{
    http_response_code(404);
    exit();
}

$question = htmlspecialchars($_POST['q']);

\Ondine\Engine::setup($default);
$instance = \Ondine\Engine::getInstance();
$instance->ask($question);
$instance->show(true);