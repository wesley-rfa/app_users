<?php

namespace App\Exceptions;

use App\Http\Responses\ApiResponse;
use App\Enum\errorCodeEnum;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    protected function invalidJson($request, ValidationException $exception)
    {
        $apiResponse = new ApiResponse();
        return $apiResponse->responseErrorEnveloper($request, errorCodeEnum::ValidationError, $exception->errors());
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            $apiResponse = new ApiResponse();
            return $apiResponse->responseErrorEnveloper($request, ErrorCodeEnum::NotFoundModel);
        }

        return parent::render($request, $exception);
    }
}
