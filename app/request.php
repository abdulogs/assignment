<?php

class Request
{
    public static function all()
    {
        return array_merge($_GET, $_POST, $_FILES);
    }

    public static function get($key, $default = null)
    {
        return $_REQUEST[$key] ?? $default;
    }

    public static function has($key)
    {
        return isset($_REQUEST[$key]);
    }

    public static function only(array $keys)
    {
        return array_intersect_key($_REQUEST, array_flip($keys));
    }

    public static function except(array $keys)
    {
        return array_diff_key($_REQUEST, array_flip($keys));
    }

    public static function isPost()
    {
        return $_SERVER["REQUEST_METHOD"] === "POST";
    }

    public static function isGet()
    {
        return $_SERVER["REQUEST_METHOD"] === "GET";
    }

    public static function isAjax()
    {
        return !empty($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) === "xmlhttprequest";
    }

    public static function fullUrl()
    {
        $protocol = (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off") ? "https://" : "http://";
        return $protocol . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    }

    public static function path()
    {
        return parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    }

    public static function json()
    {
        return json_decode(file_get_contents("php://input"), true) ?? [];
    }
    public static function reload($time = "")
    {
        if (empty($time)) {
            echo "<script>location.reload();</script>";
        } else if (!empty($time)) {
            echo "<script>setTimeout(function() { location.reload();}, {$time});</script>";
        }
    }

    public static function redirect($path)
    {
        header("Location: {$path}");
    }
}



function request()
{
    return new Request();
}
