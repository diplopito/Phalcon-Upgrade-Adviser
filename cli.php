<?php

use Phalcon\Di\FactoryDefault\Cli as CliDI;
use Phalcon\Cli\Console;
use Phalcon\Loader;

$phalconVersion = Phalcon\Version::get();

if ($phalconVersion[0] <> "4") {
    exit("The Upgrade Adviser only works with Phalcon 4.x");
}

require_once('library/consts/Phalcon3to4.php');

$di = new CliDI;

$loader = new Loader();
$loader->registerDirs(
    [
        __DIR__ . '/tasks'
    ]
);
$loader->registerClasses(
    [
        'Utils' => __DIR__ . '/library/utils/Utils.php'
    ]
);
$loader->register();

$console = new Console();
$console->setDI($di);

$arguments = [];

foreach ($argv as $k => $arg) {
    if ($k === 1) {
        $arguments['task'] = $arg;
    } elseif ($k === 2) {
        $arguments['action'] = $arg;
    } elseif ($k >= 3) {
        $arguments['params'][] = $arg;
    }
}

try {
    $console->handle($arguments);
} catch (\Phalcon\Exception $e) {
    fwrite(STDERR, $e->getMessage() . PHP_EOL);
    exit(1);
} catch (\Throwable $throwable) {
    fwrite(STDERR, $throwable->getMessage() . PHP_EOL);
    exit(1);
} catch (\Exception $exception) {
    fwrite(STDERR, $exception->getMessage() . PHP_EOL);
    exit(1);
}
