<?php

namespace hfm\helpers;

class Validator
{
    function register($data): array
    {
        $error = '';
        $status = true;

        $columns = array('fname', 'lname', 'country', 'prefix', 'phone', 'email', 'password');

        foreach ($columns as $column) {
            if (!isset($data[$column])) {
                $error = "You must enter $column";
                $status = false;
            }
        }

        /* Firstname Validation */
        if (strlen($data['fname']) < 3) {
            $error = "First name must be at least 3 characters long";
            $status = false;
        }

        /* Last Name Validation */
        if (strlen($data['lname']) < 3) {
            $error = "Last name must be at least 3 characters long";
            $status = false;
        }

        /* Prefix Validation */
        if (!is_numeric($data['prefix'])) {
            $error = "Prefix must be a number";
            $status = false;
        }

        /* Email Validation */
        if (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
            $error = "Invalid email";
            $status = false;
        }


        /* Password Validation */
        if (strlen($data['password']) < 8) {
            $error = "Password must be at least 8 characters long";
            $status = false;
        }
        if (!preg_match('/[A-Z]/', $data['password'])) {
            $error = "Password must contain at least one uppercase letter";
            $status = false;
        }
        if (!preg_match('/[0-9]/', $data['password'])) {
            $error = 'Password must contain at least one number';
            $status = false;
        }
        if (!preg_match('/[!@#$%^&*()_+\-=\[\]{};":\\|,.<>\/?`~]/', $data['password'])) {
            $error = 'Password must contain at least one special character';
            $status = false;
        }

        return array($status, $error);
    }
}