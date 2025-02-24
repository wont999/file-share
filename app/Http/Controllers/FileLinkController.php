<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\FileLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileLinkController extends Controller
{
    public function __construct()
    {
        //подключение защиты
        $this->middleware('auth:sanctum')->except(['download']);
    }


    //создание ссылки с паролем
    public function store(Request $request, File $file)
    {
        if ($file->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $request->validate([
            'password' => 'required|string|min:6',
        ]);

        //генерация ссылки
        $token = Str::random(64);

        $link = FileLink::create([
            'file_id' => $file->id,
            'token' => $token,
            'password' => Hash::make($request->password),
            'is_used' => false,
        ]);

        return response()->json([
            'message' => 'Ссылка успешно создана',
            'link' => $link
        ], 201);

    }


    //получить ссылки для файла
    public function index(File $file)
    {
        if ($file->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $links = $file->links()->latest()->get();
        return response()->json([
            'links' => $links,
        ]);
    }

    //скачивание файла по ссылке
    public function download(Request $request, $token)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $link = FileLink::where('token', $token)->firstOrFail();

        if ($link->is_used) {
            return response()->json([
                'message' => 'Ссылка уже использована',
            ]);
        }
        if (!Hash::check( $request->password, $link->password)) {
            return response()->json([
                'message' => 'Неверный пароль'
            ], 403);
        }

        $file = $link->file;
        if (!Storage::disk('local')->exists($file->path)) {
            return response()->json([
                'message' => 'Файл не найден на сервере'
            ], 404);
        }

        $link->update(['is_used' => true]);
        return Storage::disk('local')->download(
            $file->path,
            $file->original_name,
            ['Content-Type' => $file->mime_type]
        );

    }

    //удаление ссылки
    public function destroy(FileLink $link)
    {
        if ($link->file->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $link->delete();

        return response()->json([
            'message' => 'Ссылка успешно удалена',
        ]);
    }

}
