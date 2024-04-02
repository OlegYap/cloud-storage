<?php

namespace App\Http\Controllers;
use App\Mail\MailSend;
use App\Models\User;
use App\Http\Requests\FileRequest;
use App\Models\File;
use App\Models\Folder;
use App\Services\FileService;
use App\Services\RabbitMqService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Util\Exception;


class FileController
{
    private $fileService;
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function uploadFile(FileRequest $request)
    {
        $file = $request->file('file');
        $result = $this->fileService->upload($file);
        if ($result) {
            return redirect(url("main"));
        } else {
            return view('errorFile');
        }
    }

    public function downloadFile(int $fileId)
    {
/*        $userId = Auth::id();
        $file = File::where('id', $fileId)->where('user_id', $userId)->firstOrFail();*/
        $user = Auth::user();
        $file = $user->files()->findOrFail($fileId);
        if ($file->user_id !== Auth::id()) {
            return redirect()->route('login');
        }
        $pathToFile = public_path('uploads/' . $file->name);

        return response()->download($pathToFile);
    }

    public function viewFile(int $fileId)
    {
/*        $userId = Auth::id();
        $file = File::where('id', $fileId)->where('user_id', $userId)->firstOrFail();*/

        $user = Auth::user();
        $file = $user->files()->findOrFail($fileId);

        if ($file->user_id !== Auth::id()) {
            return redirect()->route('login');
        }
        $pathToFile = public_path('uploads/' . $file->name);
        return response()->file($pathToFile);
    }
}
