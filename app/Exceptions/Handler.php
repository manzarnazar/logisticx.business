<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;


class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
    // public function register()
    // {
    //     $this->reportable(function (Throwable $e) {
    //         //
    //     });
    // }

    public function report(Throwable $e)
    {
        parent::report($e);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->is('api/*') || $request->wantsJson()) {
            $data  = [
                'success'   => false,
                'message'   => ___('alert.token_expired'),
                'error' =>     $exception->getMessage(),
                // 'error'     => ___('alert.unauthenticated.'),

            ];

            return response()->json($data, 401);
        }

        // For non-JSON requests, handle redirection or other behavior
        return redirect()->guest(route('login'));
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof HttpExceptionInterface) {
            $statusCode = $e->getStatusCode();
            // For API requests, always return JSON response
            if ($request->is('api/*') || $request->wantsJson()) {
                return new JsonResponse(['error' => Response::$statusTexts[$statusCode]], $statusCode);
            }

            // For web requests, return corresponding view
            if (view()->exists('errors.' . $statusCode)) {
                return response()->view('errors.' . $statusCode, [], $statusCode);
            } else {
                // If the view doesn't exist, return a generic error response
                return response()->view('errors.generic', [], $statusCode);
                // return parent::render($request, $e);
            }
        }

        // Fallback to parent handler for other exceptions
        return parent::render($request, $e);
    }


    // public function render($request, Throwable $e)
    // {

    //     if ($this->isHttpException($e)) {

    //         if ($e->getStatusCode()       == 401) {

    //             return response()->view('errors.401');
    //         } elseif ($e->getStatusCode()  == 403) {

    //             return response()->view('errors.403');
    //         } elseif ($e->getStatusCode()  == 404) {
    //             return response()->view('errors.404');
    //         } elseif ($e->getStatusCode() == 419) {

    //             return response()->view('errors.419');
    //         } elseif ($e->getStatusCode() == 429) {

    //             return response()->view('errors.429');
    //         } elseif ($e->getStatusCode() == 500) {

    //             return response()->view('errors.500');
    //         } elseif ($e->getStatusCode() == 503) {

    //             return response()->view('errors.503');
    //         }
    //     } else {
    //         // return response()->view('errors.500');
    //         return  parent::render($request, $e);
    //     }
    // }


}
