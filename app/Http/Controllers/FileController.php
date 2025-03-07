<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(File::class, 'file');
    }

    //получение всех файлов пользователя
    public function index()
    {
        $files = auth()->user()->files()->with('links')->latest()->get();
        return response()->json([
            'files' => $files
        ]);
    }

    //получение ссылок для файла
    public function show(File $file)
    {


        $file->load('links');

        return response()->json(['file' => $file]);
    }

    //добавление файла
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // максимум 10MB
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $fileName = time() . '_' . $originalName;

        //сохранение файла
        $path = $file->storeAs('user_files', $fileName, 'local');

        //создание записи в БД
        $file = File::create([
            'user_id' => auth()->id(),
            'name' => $fileName,
            'original_name' => $originalName,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'path' => $path,
        ]);

        return response()->json([
            'message' => 'Файл успешно загружен',
            'file' => $file
        ], 201);
    }

    //удаление файла
    public function destroy(File $file)
    {


        // удаление физического файла и записи в БД
        Storage::disk('local')->delete($file->path);
        $file->delete();

        return response()->json(['message' => 'Файл успешно удален']);
    }
}
