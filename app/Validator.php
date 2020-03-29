<?php

namespace App;

class Validator
{
    private $data = [];
    private $passes = false;
    private $fails = false;

    public function make(array $data, array $rules)
    {
        if (!count($data) || !count($rules)) return false;
        $this->data = $data;
        $errors = [];

        foreach ($rules as $inputName => $_rules) {
            $_rules = trim($_rules);

            if (!empty($_rules)) {

                if (strpos($_rules, '|') !== false) {
                    $exploded = explode('|', $_rules);

                    foreach ($exploded as $rule) {
                        $rule = trim($rule);

                        if (strpos($rule, ':') !== false) {
                            list($_rule, $value) = explode(':', $rule);
                            $validate = $this->validate($inputName, $_rule, $value);
                        } else {
                            $validate = $this->validate($inputName, $rule);
                        }

                        if ($validate != false) {
                            $errors[$inputName][] = $validate;
                        }
                    }

                } else {

                    if (strpos($_rules, ':') !== false) {
                        list($_rule, $value) = explode(':', $_rules);
                        $validate = $this->validate($inputName, $_rule, $value);
                    } else {
                        $validate = $this->validate($inputName, $_rules);
                    }

                    if ($validate != false) {
                        $errors[$inputName] = $validate;
                    }
                }
            }
        }

        if (count($errors)) {
            $this->fails = true;
            return $errors;
        }

        $this->passes = true;
        return false;
    }

    public function passes() {
        return $this->passes;
    }

    public function fails() {
        return $this->fails;
    }

    private function validate($inputName, $rule, $value = null)
    {
        $error = '';

        switch ($rule) {
            case 'required':
                $required = $this->checkRequired($inputName);
                if ($required) $error = $required;
                break;

            case 'string':
                $string = $this->checkString($inputName);
                if ($string) $error = $string;
                break;

            case 'email':
                $email = $this->checkEmail($inputName);
                if ($email) $error = $email;
                break;

            case 'url':
                $url = $this->checkUrl($inputName);
                if ($url) $error = $url;
                break;

            case 'min':
                $min = $this->checkMinimumLength($inputName, $value);
                if ($min) $error = $min;
                break;

            case 'max':
                $max = $this->checkMaximumLength($inputName, $value);
                if ($max) $error = $max;
                break;

            default:

                break;
        }

        if (!empty($error)) return $error;
        return false;
    }

    private function checkMinimumLength($inputName, $value) {

        if (strlen($this->data[$inputName]) < $value) {
            return "The {$this->modifyInputFieldName($inputName)} field value minimum {$value} character.";
        }

        return false;
    }

    private function checkMaximumLength($inputName, $value) {

        if (strlen($this->data[$inputName]) > $value) {
            return "The {$this->modifyInputFieldName($inputName)} field value maximum {$value} character.";
        }

        return false;
    }

    private function checkRequired($inputName) {

        if (empty($this->data[$inputName])) {
            return "The {$this->modifyInputFieldName($inputName)} field is required.";
        }

        return false;
    }

    private function checkString($inputName) {

        if (!is_string($this->data[$inputName])) {
            return "The {$this->modifyInputFieldName($inputName)} field value must be string.";
        }

        return false;
    }

    private function checkEmail($inputName) {

        if (!filter_var($this->data[$inputName], FILTER_VALIDATE_EMAIL)) {
            return "The {$this->modifyInputFieldName($inputName)} field value must be email.";
        }

        return false;
    }

    private function checkUrl($inputName) {

        $regex = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
        
        if (!preg_match($regex, $this->data[$inputName])) {
            return "The {$this->modifyInputFieldName($inputName)} field value must be url.";
        }

        return false;
    }

    private function modifyInputFieldName($name)
    {
        $name = str_replace('_', ' ', $name);
        $name = str_replace('-', ' ', $name);
        $name = preg_replace('/([A-Z])/', " $1", $name);
        $name = strtolower($name);
        return $name;
    }

    public function __toString()
    {
        return "Validator Class";
    }
}
