<?php

class Auth
{
    public $user;


    function __construct()
    {
        $this->user = query()->select("*")->from("users")->where(["id" => session()->get("id")])->execute()->fetch("one");
    }


    function authenticate($email, $password)
    {
        $data = query()->select("*")->from("users")->where(["email" => $email])->execute()->fetch("one");

        if (!$data) {
            session()->flash("error", "Email with this account not exists in database");
            return;
        }

        if (password_verify($password, $data['password'])) {
            session()->put("id", $data["id"]);
            session()->flash("success", "Login Successfully");
            return true;
        } else {
            session()->flash("error", "Incorrect password");
            return;
        }
    }

    function signup($data)
    {
        $data = query()->create("users", $data)->execute();
    }

    function user()
    {
        return $this->user;
    }
}

function auth()
{
    return new Auth();
}
