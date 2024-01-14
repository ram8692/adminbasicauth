<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;

class AuthValidators extends Validator
{
    public static function validate(string $action, array $data)
    {
        $rules = self::getValidationRules($action);

        return Validator::make($data, $rules);
    }

    private static function getValidationRules(string $action): array
    {
        switch ($action) {
            case 'login':
                return [
                    'email' => ['required', 'string', 'email'],
                    'password' => ['required', 'string'],
                ];
            // Add more cases for other actions
            default:
                return [];
        }
    }
}
