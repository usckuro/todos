<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
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
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if($exception instanceof AccessDeniedHttpException){
            return new Response(['message' => $exception->getMessage()], 403);
        }

        if ($exception instanceof TokenExpiredException) {
            return new Response(['message' => 'Token expired'], 401);
        }

        if ($exception instanceof JWTException) {
            return new Response(['message' => $exception->getMessage() ?: 'Unauthorized'], 401);
        }

        if ($exception instanceof NotFoundHttpException) {
            return new Response(['message' => 'Not found'], 404);
        }

        if ($exception instanceof HttpException) {
            return new Response(['message' => $exception->getMessage()], $exception->getStatusCode());
        }

        if($exception instanceof QueryException){
            return new Response(['message' => $exception->getMessage()], 500);
        }

        if($exception instanceof ModelNotFoundException)
        {
            return new Response(['message' => 'Invalid parameter'], 401);
        }
        return parent::render($request, $exception);
    }
}
