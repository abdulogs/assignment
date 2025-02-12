<?php
class CSRF
{
    private $token;

    function __construct()
    {
        if (!isset($_SESSION["_csrf_token"])) {
            $this->token = bin2hex(random_bytes(32));
            session()->put("_csrf_token", $this->token);
        }
        $this->token = session()->get("_csrf_token", null);
    }

    public function token()
    {
        return $_SESSION["_csrf_token"] ?? $this->token;
    }

    public function verify()
    {
        return hash_equals(session()->get("_csrf_token"), request()->get("_csrf_token", "xyz"));
    }

    public function field()
    {
        return "<input type='hidden' name='_csrf_token' value='" . $this->token() . "'>";
    }

    function __destruct()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!$this->verify()) {
                $this->token = session()->put("_csrf_token", null);
                die("CSRF validation failed.");
            }
        }
    }
}

function csrf()
{
    return new  CSRF();
}
