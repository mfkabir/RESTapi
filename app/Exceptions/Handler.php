<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
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

    public function render($request, Throwable $e)
    {
        if($request->is('api*')){
            if($e instanceof \Illuminate\Validation\ValidationException){
                return response([
                    'status' => 'error',
                    'errors' => $e->errors()
                ], 422);
            }
    
            if($e instanceof \Illuminate\Auth\Access\AuthorizationException){
                return response([
                    'status' => 'error',
                    'errors' => $e->getMessage()
                ], 403);
            }

            return response([
                'status' => 'error',
                'error' => 'Something went terribly wrong!!!'
            ], 500);
        }
        parent::render($request, $e);
    }
}
