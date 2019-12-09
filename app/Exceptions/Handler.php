<?php

namespace App\Exceptions;

use App\Traits\APIResponser;
use Exception;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{

    use APIResponser;

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof HttpException){
            $code = $exception->getStatusCode();
            $message = Response::$statusTexts[$code];
            return $this->errorResponse($message, $code);
        }

        if ($exception instanceof ModelNotFoundException){
            $model = strtolower(class_basename($exception->getModel()));
            $message = "Does not exist any instance of {$model} for the given id";
            return $this->errorResponse($message, Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof AuthorizationException){

            $message = $exception->getMessage();
            return $this->errorResponse($message, Response::HTTP_FORBIDDEN);
        }

        if ($exception instanceof AuthenticationException){

            $message = $exception->getMessage();
            return $this->errorResponse($message, Response::HTTP_UNAUTHORIZED);
        }

        if ($exception instanceof ValidationException){

            $message = $exception->validator->errors()->getMessages();
            return $this->errorResponse($message, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($exception instanceof ClientException){

            $message = $exception->getResponse()->getBody();
            $code = $exception->getCode();

            return $this->errorMessage($message, $code);
        }

        if (env('APP_DEBUG', false)) {
            return parent::render($request, $exception);
        }

        $message = "Unexpected Error. Try later.";
        return $this->errorResponse($message, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
