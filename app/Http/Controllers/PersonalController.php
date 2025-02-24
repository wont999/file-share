<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PersonalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $files = auth()->user()->files()->latest()->get();
        return response()->json(['files' => $files]);
    }
}
