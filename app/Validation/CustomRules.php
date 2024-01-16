<?php namespace App\Validation;

use CodeIgniter\Validation\Rules;

class CustomRules extends Rules
{
    public function date_not_in_past(string $str, string &$error = null): bool
    {
        $today = date('Y-m-d');
        if ($str < $today) {
            $error = 'The date must not be earlier than today.';
            return false;
        }
        return true;
    }

    public function date_not_earlier_than(string $str, string $field, array $data, string &$error = null): bool
    {
        if ($str < $data[$field]) {
            $error = 'The return date must not be earlier than the departure date.';
            return false;
        }
        return true;
    }

    public function location_not_same(string $str, string $field, array $data, string &$error = null): bool
    {
        if ($str == $data[$field]) {
            $error = 'The start location and end location must not be the same.';
            return false;
        }
        return true;
    }
}
