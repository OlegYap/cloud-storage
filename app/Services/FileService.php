<?php

namespace App\Services;

use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FileService
{
    protected $rabbitMqService;

    public function __construct()
    {
        $this->rabbitMqService = new RabbitMqService('rabbitmq', 5672, 'user', 'password');;
    }
    public function upload($file)
    {
        try {
            $destinationPath = "uploads/";
            $fileName = $file->getClientOriginalName();
            if ($file->move($destinationPath, $fileName)) {
                $fileData = new File();
                $fileData->name = $fileName;
                $fileData->path = $file->getRealPath();
                $fileData->size = $file->getSize();
                $fileData->type = $file->getClientMimeType();
                $fileData->user_id = Auth::id();
                $fileData->folder_id = 0;
                $fileData->created_at = now();
                $fileData->updated_at = now();
                $fileData->save();

                $message = [
                    'email' => Auth::user()->email,
                    'name' => $fileName,
                ];
                Log::info('Проверка отправки', $message);
                $this->rabbitMqService->publish('email', json_encode($message));
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $exception) {
            Log::error('Ошибка при загрузке файла: ' . $exception->getMessage());
            if (file_exists($destinationPath . $fileName)) {
                unlink($destinationPath . $fileName);
            }
            return false;
        }
    }
}
