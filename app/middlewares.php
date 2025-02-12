<?php

class Middleware
{
    public static function login($value, $path = "")
    {
        if (session()->has($value)) {
            request()->redirect($path);
        }
    }

    public static function logout($value, $path = "")
    {
        if (!session()->has($value)) {
            request()->redirect($path);
        }
    }
}

function middleware()
{
    return new Middleware();
}
