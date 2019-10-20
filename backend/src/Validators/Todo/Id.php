<?php

declare(strict_types = 1);

namespace App\Validators\Todo;


use App\Validators\ParamValidator;
use Awurth\SlimValidation\Validator as V;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator;


/**
 * Class Id
 * @package App\Validators\Todo
 */
class Id extends ParamValidator {
    /**
     * {@inheritDoc}
     */
    public function validate(V $validator, Request $request): V {
        $validate = [
            'id' => Validator::numeric()->min(1),
        ];

        return $validator->validate($request, $validate);
    }
}