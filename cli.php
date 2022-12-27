<?php

$arguments = [];

foreach ($argv as $k => $arg) {
    if ($k === 1) {
        $arguments['classes'] = $arg;
    } elseif ($k === 2) {
        $arguments['path'] = $arg;
    } elseif ($k === 3) {
        $arguments['logfile'] = $arg;
    }
}

if (empty($arguments)) {
    die("Please type the conversion type, path to the directory or file and (optional) the log file to use");
}

if ($arguments['classes'] === 'v3to4') {
    $classes = include_once('v3to4.php');
} else if ($arguments['classes'] === 'v4to5') {
    $classes = include_once('v4to5.php');
} else if ($arguments['classes'] === 'v3to5') {
    $classes = include_once('v3to5.php');
} else {
    die("Conversion " . $arguments['classes'] . " not supported");
}

include_once('adviser.php');

$adviser = new Adviser(
    $classes,
    $arguments['path'],
    $arguments['logfile'] ?? ''
);

$adviser->createLogAction();

