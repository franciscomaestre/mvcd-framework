<?php


// add include paths
function add_include_path($path) {
    set_include_path(get_include_path() . PATH_SEPARATOR . $path);
}

spl_autoload_register(function ($class) {
    $classES = str_replace('\\', '/', $class);
    include_once $classES . '.php';
});


