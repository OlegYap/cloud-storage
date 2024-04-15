<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'path',
        'size',
        'type',
        'user_id',
        'folder_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    /*public $timestamps = false;*/ // Решает проблему со столбцами updated_at, created_at. Команда отключает автоматическое вставление данных в столбцы.
}

