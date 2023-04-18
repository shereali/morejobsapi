<?php

namespace App\Http\Requests;

use Illuminate\Container\Container;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidatesWhenResolvedTrait;
use Illuminate\Validation\ValidationException;

class FormRequest extends Request implements ValidatesWhenResolved
{
    use ValidatesWhenResolvedTrait;

    protected function getValidatorInstance()
    {
        $factory = $this->container->make(ValidationFactory::class);
        if (method_exists($this, 'validator')) {
            return $this->container->call([$this, 'validator'], compact('factory'));
        }

        return $factory->make(
            $this->validationData(), $this->container->call([$this, 'rules']), $this->messages(), $this->attributes()
        );
    }

    protected function validationData()
    {
        return $this->all();
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException(
            $validator,
            new JsonResponse($validator->errors()->getMessages(),
                Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

    protected function passesAuthorization()
    {
        if (method_exists($this, 'authorize')) {
            return $this->container->call([$this, 'authorize']);
        }
        return false;
    }

    protected function failedAuthorization()
    {
        throw new UnauthorizedException($this->forbiddenResponse());
    }

    public function forbiddenResponse()
    {
        return new Response('Forbidden', 403);
    }


    public function setContainer(Container $container)
    {
        $this->container = $container;
        return $this;
    }

    public function rules()
    {
        return [];
    }

    public function messages()
    {
        return [];
    }

    public function attributes()
    {
        return [];
    }
}
