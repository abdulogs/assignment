<?php
function config($key)
{
    global $config;

    $keys = explode(".", $key);
    $value = $config;

    foreach ($keys as $keyPart) {
        if (isset($value[$keyPart])) {
            $value = $value[$keyPart];
        } else {
            return null;
        }
    }

    return $value;
}


function base_path($path)
{
    return dirname(__DIR__) . "/" . $path;
}


function component($component)
{
    require_once base_path("components/" . $component . ".php");
}


function flush_errors()
{
    session()->forget("errors");
}
