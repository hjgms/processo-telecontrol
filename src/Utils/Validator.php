<?php

namespace App\Utils;

class Validator
{
    public static function validate(array $fields)
    {
        foreach ($fields as $field => $value) {
            if (empty(trim($value))) {
                throw new \Exception("The field ($field) is required.");
            }
        }

        return $fields;
    }

    public static function validateId($id) {
        if (!is_numeric($id) || $id <= 0) {
            throw new \InvalidArgumentException("ID inválido");
        }
    }
}