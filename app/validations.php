<?php

class Validator
{
    protected $errors = [];

    public function validate($data, $rules)
    {
        foreach ($rules as $field => $ruleSet) {
            $rulesArray = explode("|", $ruleSet);
            if (isset($data[$field])) {
                foreach ($rulesArray as $rule) {
                    $this->applyRule($field, $data, $rule);
                }
            }
        }
        return $this;
    }

    protected function applyRule($field, $data, $rule)
    {
        if ($rule === "required" && empty($data[$field])) {
            $this->errors[$field][] = ucfirst($field) . " is required.";
        } elseif (strpos($rule, "min:") === 0) {
            $min = explode(":", $rule)[1];
            if (strlen($data[$field]) < $min) {
                $this->errors[$field][] = ucfirst($field) . " must be at least $min characters.";
            }
        } elseif (strpos($rule, "max:") === 0) {
            $max = explode(":", $rule)[1];
            if (strlen($data[$field]) > $max) {
                $this->errors[$field][] = ucfirst($field) . " must be at most $max characters.";
            }
        } elseif ($rule === "email" && !filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = ucfirst($field) . " must be a valid email.";
        }
        session()->put("errors", $this->errors);
    }

    public function fails()
    {
        return !empty($this->errors);
    }

    public function errors()
    {
        return $this->errors;
    }

    function __destruct()
    {
        
    }
}

function IsError($key)
{
    return isset(session()->get("errors")[$key][0]) ? true : false;
}

function error($key, $default = false)
{
    echo session()->get("errors")[$key][0] ?? $default;
}

function validator()
{
    return new Validator();
}
