<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        switch (get_class($exception)) {
            case ValidationException::class:
                return response()->json([
                    'errors' => $exception->validator->getMessageBag()
                ], Response::HTTP_BAD_REQUEST);
            case NotFoundHttpException::class:
                return response()->json([
                    'errors' => 'Page not found'
                ], Response::HTTP_NOT_FOUND);
            case AuthenticationException::class:
                return response()->json(['
                    error' => 'Unauthenticated'
                ], Response::HTTP_UNAUTHORIZED);
            default:
                return parent::render($request, $exception);
        }
    }
}
