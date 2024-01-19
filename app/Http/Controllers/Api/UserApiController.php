<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserApiController extends Controller
{

    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $user = User::create($request->all());
        return response()->json($user, Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }
        return response()->json($user);
    }

    public function update(Request $request, string $id)
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
