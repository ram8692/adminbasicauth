<?php 
// app/Validators/MyValidator.php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;

class UserValidators extends Validator
{
    public static function validate(string $action, array $data)
    {
        $rules = self::getValidationRules($action);

        return Validator::make($data, $rules);
    }

    private static function getValidationRules(string $action): array
    {
        switch ($action) {
            case 'createUser':
                return [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                ];
            case 'updateUser':
                return [
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|max:255',
                    // Add more rules as needed
                ];
            // Add more cases for other actions
            default:
                return [];
        }
    }
}
