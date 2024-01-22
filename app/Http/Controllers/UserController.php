<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{

    public function index()
    {
        return view('app.user.index');
    }

    public function create()
    {
        return view('app.user.create');
    }

    public function show(string $id)
    {
        return view('app.user.show', compact('id'));
    }

    public function edit(string $id)
    {
        return view('app.user.edit', compact('id'));
    }
}
