<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('app.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.user.create');
    }
    
    public function store(Request $request)
    {

    }

    public function show(string $id)
    {
        return view('app.user.show', compact('id'));
    }
    
    public function edit(string $id)
    {
        return view('app.user.edit', compact('id'));
    }
    
    public function update(Request $request, string $id)
    {

    }
    
    public function destroy(string $id)
    {

    }
}
