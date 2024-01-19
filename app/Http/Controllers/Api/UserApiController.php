<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use App\Enum\ErrorCodeEnum;
use Illuminate\Http\Request;
use Exception;

class UserApiController extends Controller
{
    public function __construct(
        private $response = new ApiResponse()
    ) {
    }

    public function index(Request $request)
    {
        try {
            $users = User::all();
            return $this->response->responseEnveloper(data: $users);
        } catch (Exception $e) {
            Log::channel('controllers')->warning(
                'UserApiController - Undefined error on index',
                [
                    'messageError' => $e->getMessage(),
                    'codeError' => $e->getCode(),
                    'lineError' => $e->getLine(),
                    'fileError' => $e->getFile()
                ]
            );
            $error['exceptionMessage'] = $e->getMessage();
            return $this->response->responseErrorEnveloper(request: $request, errorCodeEnum: ErrorCodeEnum::InternalServerError, errors: $error);
        }
    }

    public function store(StoreUserRequest $request)
    {
        try {
            $user = User::create($request->validated());
            return $this->response->responseEnveloper(data: $user, statusCode: Response::HTTP_CREATED);
        } catch (Exception $e) {
            Log::channel('controllers')->warning(
                'UserApiController - Undefined error on store',
                [
                    'messageError' => $e->getMessage(),
                    'codeError' => $e->getCode(),
                    'lineError' => $e->getLine(),
                    'fileError' => $e->getFile()
                ]
            );
            $error['exceptionMessage'] = $e->getMessage();
            return $this->response->responseErrorEnveloper(request: $request, errorCodeEnum: ErrorCodeEnum::InternalServerError, errors: $error);
        }
    }

    public function show(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            return $this->response->responseEnveloper(data: $user);
        } catch (ModelNotFoundException $e) {
            Log::channel('controllers')->warning(
                'UserApiController - Not found error on show',
                [
                    'messageError' => $e->getMessage(),
                    'codeError' => $e->getCode(),
                    'lineError' => $e->getLine(),
                    'fileError' => $e->getFile()
                ]
            );
            $error['exceptionMessage'] = $e->getMessage();
            return $this->response->responseErrorEnveloper(request: $request, errorCodeEnum: ErrorCodeEnum::NotFoundModel, errors: $error);
        } catch (Exception $e) {
            Log::channel('controllers')->warning(
                'UserApiController - Undefined error on show',
                [
                    'messageError' => $e->getMessage(),
                    'codeError' => $e->getCode(),
                    'lineError' => $e->getLine(),
                    'fileError' => $e->getFile()
                ]
            );
            $error['exceptionMessage'] = $e->getMessage();
            return $this->response->responseErrorEnveloper(request: $request, errorCodeEnum: ErrorCodeEnum::InternalServerError, errors: $error);
        }
    }

    public function update(UpdateUserRequest $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update($request->all());
            return $this->response->responseEnveloper(data: $user);
        } catch (ModelNotFoundException $e) {
            Log::channel('controllers')->warning(
                'UserApiController - Not found error on update',
                [
                    'messageError' => $e->getMessage(),
                    'codeError' => $e->getCode(),
                    'lineError' => $e->getLine(),
                    'fileError' => $e->getFile()
                ]
            );
            $error['exceptionMessage'] = $e->getMessage();
            return $this->response->responseErrorEnveloper(request: $request, errorCodeEnum: ErrorCodeEnum::NotFoundModel, errors: $error);
        } catch (Exception $e) {
            Log::channel('controllers')->warning(
                'UserApiController - Undefined error on update',
                [
                    'messageError' => $e->getMessage(),
                    'codeError' => $e->getCode(),
                    'lineError' => $e->getLine(),
                    'fileError' => $e->getFile()
                ]
            );
            $error['exceptionMessage'] = $e->getMessage();
            return $this->response->responseErrorEnveloper(request: $request, errorCodeEnum: ErrorCodeEnum::InternalServerError, errors: $error);
        }
    }

    public function destroy(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return $this->response->responseEnveloper(data: [], statusCode: Response::HTTP_NO_CONTENT);
        } catch (ModelNotFoundException $e) {
            Log::channel('controllers')->warning(
                'UserApiController - Not found error on destroy',
                [
                    'messageError' => $e->getMessage(),
                    'codeError' => $e->getCode(),
                    'lineError' => $e->getLine(),
                    'fileError' => $e->getFile()
                ]
            );
            $error['exceptionMessage'] = $e->getMessage();
            return $this->response->responseErrorEnveloper(request: $request, errorCodeEnum: ErrorCodeEnum::NotFoundModel, errors: $error);
        } catch (Exception $e) {
            Log::channel('controllers')->warning(
                'UserApiController - Undefined error on destroy',
                [
                    'messageError' => $e->getMessage(),
                    'codeError' => $e->getCode(),
                    'lineError' => $e->getLine(),
                    'fileError' => $e->getFile()
                ]
            );
            $error['exceptionMessage'] = $e->getMessage();
            return $this->response->responseErrorEnveloper(request: $request, errorCodeEnum: ErrorCodeEnum::InternalServerError, errors: $error);
        }
    }
}
