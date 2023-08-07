<?php

namespace App\Traits;

use Illuminate\Support\Facades\Validator;
use App\Exceptions\InvalidFieldException;

trait ValidatesFields{

    /**
     * Validates given fields using Laravel's validation system. Throws an InvalidFieldException containing error messages with JSON format if validation fails.
     * @param array<mixed> $fields Associative array of fields and it's values
     * @param array<mixed> $rules Validation rules following Validator Class' requisites
     * @return bool Returns true if all fields are valid
     * @throws InvalidFieldException
     */
    protected static function validate(array $fields, array $rules) : bool{
        $response = true;
        $validator = Validator::make($fields,$rules);

        if($validator->fails()){
            throw new InvalidFieldException($validator->messages()->toJson());
        }

        return $response;
    }

}