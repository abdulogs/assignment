<?php

class Session
{
    private static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function put($key, $value)
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null)
    {
        self::start();
        return $_SESSION[$key] ?? $default;
    }

    public static function has($key)
    {
        self::start();
        return isset($_SESSION[$key]);
    }

    public static function forget($key)
    {
        self::start();
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public static function flush()
    {
        self::start();
        $_SESSION = [];
        session_destroy();
    }

    public static function flash($key, $value)
    {
        self::start();
        $_SESSION["flash"][$key] = $value;
    }

    public static function message($key, $default = null)
    {
        self::start();
        if (isset($_SESSION["flash"][$key])) {
            $value = $_SESSION["flash"][$key];
            unset($_SESSION["flash"][$key]); // Remove flash message after reading
            return $value;
        }
        return $default;
    }
}

function session()
{
    return new Session();
}
