<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;
    protected $table = 'file_folders';

    protected $fillable = [
        'name',
        'user_id',
        'parent_id'
    ];
    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function subfolders()
    {
        return $this->hasMany(Folder::class, 'parent_id');
    }

    public $timestamps = false; // Решает проблему со столбцами updated_at, created_at. Команда отключает автоматическое вставление данных в столбцы.
}

