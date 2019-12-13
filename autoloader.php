<?php

spl_autoload_register(function($className){

    $ds = DIRECTORY_SEPARATOR;
    $dir = __DIR__;

    $className = str_replace('\\', $ds, $className);

    $file = "{$dir}{$ds}{$className}.php";

    // echo "<br>Path: $file";

    if (is_readable($file)) require_once $file;
    // else echo "<br>Doesn't exist";

    // exit();
});