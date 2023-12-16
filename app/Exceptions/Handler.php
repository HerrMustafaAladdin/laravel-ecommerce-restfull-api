<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Error;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponser;
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if($e instanceof ModelNotFoundException)
        {
            return $this->errorResponce($e->getMessage(), 404);
        }

        if($e instanceof NotFoundHttpException)
        {
            return $this->errorResponce($e->getMessage(), 404);
        }

        if($e instanceof MethodNotAllowedHttpException)
        {
            return $this->errorResponce($e->getMessage(), 404);
        }

        if($e instanceof Exception)
        {
            return $this->errorResponce($e->getMessage(), 404);
        }

        if($e instanceof Error)
        {
            return $this->errorResponce($e->getMessage(), 404);
        }

        if(config('app.debug'))
        {
            return parent::render($request, $e);
        }

        return $this->errorResponce($e->getMessage(), 500);
    }
}
