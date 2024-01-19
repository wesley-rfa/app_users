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

    public function index()
    {
        $users = User::all();
        return $this->response->responseEnveloper(data: $users);
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
        return $this->response->responseEnveloper(data: $user, statusCode: Response::HTTP_CREATED);
    }

    public function show(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
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

        return $this->response->responseEnveloper(data: $user);
    }

    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::find($id);
        $user->update($request->all());

        return $this->response->responseEnveloper(data: $user);
    }

    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();

        return $this->response->responseEnveloper(data: [], statusCode: Response::HTTP_NO_CONTENT);
    }
}
