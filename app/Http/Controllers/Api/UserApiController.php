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

class UserApiController extends Controller
{
    public function __construct(
        private $response = new ApiResponse()
    ) {
    }

    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
        return response()->json($user, Response::HTTP_CREATED);
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
            return $this->response->responseErrorEnveloper($request, ErrorCodeEnum::NotFoundModel, $error);
        }
        
        return response()->json($user);
    }

    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::find($id);
        $user->update($request->all());

        return response()->json($user);
    }

    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
