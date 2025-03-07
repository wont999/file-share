<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileDownloadController extends Controller
{
    public function showDownloadForm($token)
    {
        return view('download', [
            'token' => $token
        ]);
    }
}
