<?php

declare(strict_types = 1);

namespace App\Validators\Todo;


use App\Validators\ParamValidator;
use Awurth\SlimValidation\Validator as V;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator;


/**
 * Class NewTodo
 * @package App\Validators\Todo
 */
class NewTodo extends ParamValidator {
    /**
     * {@inheritDoc}
     */
    protected function validate(V $validator, Request $request): V {
        $validate = [
            'subject' => Validator::length(1, 60),
            'description' => Validator::length(0, 255),
            'completed' => Validator::boolVal(),
        ];

        return $validator->validate($request, $validate);
    }
}