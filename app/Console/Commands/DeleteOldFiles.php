<?php

namespace App\Console\Commands;

use App\Models\File;
use Illuminate\Console\Command;
use Carbon\Carbon;

class DeleteOldFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:old-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete files older than 10 minutes';

    /**
     * Execute the console command.
     *
     *  mixed
     */
    public function handle()
    {
/*        $files = File::where('created_at', '<=', Carbon::now()->subWeek())->get();*/
        $files = File::where('created_at', '<=', Carbon::now()->subMinutes(10))->get();
        foreach ($files as $file) {
            $filePath = public_path('uploads/' . $file->name);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $file->delete();
        }
    }
}
