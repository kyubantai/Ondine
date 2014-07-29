Ondine
======

Ondine is an engine which can handle questions and try to answer to them. The limit of its answers depends of the loaded modules.

Modules are the way to add many functions and customize them.


Configuration
-------------

The engine has a default config which specifies the default response format (JSON), modules path and main dictionary path.
You can customize theses values when calling `setup()` of engine.

```php
<?php
\Ondine\Engine::setup(); // Setup engine with default config
\Ondine\Engine::setup([
'format'     => \Ondine\Engine::FORMAT_HTML,    // Set response format
'mods'       => __DIR__ . '/Mod/',              // Set modules path
'dictionary' => __DIR__ . '/dictionary.json'    // Set dictionary file path
]);
```


Modules
-------
A module is a function that ondine can use. There must be at least 2 files:

* A dictionary named `dictionary.json` at module's root (See dictionary part to learn more).
* The main class extending `\Ondine\ModController` class. **This class must have the same filename and classname as his own folder.**

See HelloWorldMod for example.


Dictionary
----------
The dictionary is used to find which module can give the best answer to the question. The module with the biggest weight after scanning the question will be executed to give an answer.

There are 2 types of dictionary:

* Main dictionary, must be generated when a module dictionary is modified. Used by the engine.
* Module's dictionary. Each module has one. They are used to build the main dictionary.


### Main dictionary
The main dictionary is a json object containing all dictionaries. This one is used by the engine at each executions.
You must re-generate it after very modification of any module dictionary.

To generate the main dictionary just execute `gen-dictionary.py`

```sh
$ python gen-dictionnary.py
[INFO] -------------------------------
[INFO] Starting process
[INFO] -------------------------------
[INFO] Read dictionary of HelloWorldMod
[INFO] Loaded 1 dictionaries
[INFO] Generating main dictionary...
[INFO] -------------------------------
[INFO] Main dictionary created successfully
[INFO] -------------------------------
```

_To avoid problems, don't edit manually the generated dictionary. Just use the python file (gen-dictionary.py) to override the existing one._


### Module dictionary
A module dictionary is a json object containing word:weight associations.

```json
{
"hello": 10,
"hey": 10,
"hi": 10
}
```

Each word must be related to the mod. **Don't add a word that doesn't have anything to do with your mod**.
For a word (key), there is an associated weight (value). This value represents the "priority" of the word for this mod.

A word with a high priority in the question will significantly increase its chances to be the _matching mod_ .


Usage
-----

```php
<?php
\Ondine\Engine::setup(); // Init the engine
$instance = \Ondine\Engine::getInstance();
$instance->ask('Hello Ondine!'); // Send question
$instance->show(); // Display answer
```

Tests
-----

```sh
$ phpunit --bootstrap vendor/autoload.php test
```