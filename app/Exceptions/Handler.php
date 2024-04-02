<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

//
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        // $this->reportable(function (Throwable $e) {
        //     //
        // });
        // Invalid request body
        $this->renderable(function (ValidationException $e, Request $request) {
            if ($request->is('api/*')) {
                $errors = $e->validator->getMessageBag()->toArray();
                $formattedErrors = [];

                foreach ($errors as $field => $messages) {
                    $formattedErrors[$field] = [
                        'message' => $messages[0]
                    ];
                }

                return response()->json([
                    'status' => 'invalid',
                    'message' => 'Request body is not valid',
                    'violations' => $formattedErrors
                ], 400);
            }
        });
        // Non-existing API path
        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 'not-found',
                    'message' => 'Not found.'
                ],   404);
            }
        });
        // Missing or invalid auth header
        $this->renderable(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                //for missing token
                if(!$request->bearerToken()){
                    return response()->json([
                        'status' => 'unauthenticated',
                        'message' => 'Missing token'
                    ],   401);
                }
                return response()->json([
                    'status' => 'unauthenticated',
                    'message' => 'Invalid token'
                ],   401);
            }
        });


    }


}
