<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponse;

    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthenticationException) {
            return $this->errorResponse('Unauthenticated', 401);
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse('The specified url can not be found!', Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($exception);
        }

        if ($exception instanceof ModelNotFoundException) {
            return $this->errorResponse('Not found!.', [], Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse('The specified method for the request is invalid ', Response::HTTP_METHOD_NOT_ALLOWED);
        }

        if ($exception instanceof UnauthorizedException) {
            return $this->errorResponse($exception->getMessage(), Response::HTTP_FORBIDDEN);
        }


        if ($exception instanceof HttpException) {
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }

        if (config('app.debug')) {
            return parent::render($request, $exception);
        }

        return $this->errorResponse('Unexpected Exception.Try later', Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e): JsonResponse
    {
        $errors = $e->validator->errors()->getMessages();

        return $this->errorResponse('Invalid data.', $errors, 422);
    }
}
