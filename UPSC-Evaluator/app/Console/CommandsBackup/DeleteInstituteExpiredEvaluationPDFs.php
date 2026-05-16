<?php

namespace App\Console\CommandsBackup;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\InstituteUploadFile;

class DeleteInstituteExpiredEvaluationPDFs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-institute-expired-evaluation-pdfs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete the expire institute evalution pdf files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->deleteInstituteExpireEvalutionPDFs();
    }

    private function deleteInstituteExpireEvalutionPDFs()
    {
        $institute_upload_files = InstituteUploadFile::select('id', 'success_file_path')
                                                    ->where('status', 1)
                                                    ->where('is_success_file_deleted', 0)
                                                    ->whereHas('upload_batch', function($query){
                                                        $query->whereRaw('TIMESTAMPDIFF(HOUR, created_at, CURRENT_TIMESTAMP) > 72');
                                                    })
                                                    ->get();

        foreach ($institute_upload_files as $key => $file) {
            if (Storage::disk('public')->exists($file->success_file_path)) {
                Storage::disk('public')->delete($file->success_file_path);
                $file->is_success_file_deleted = 1;
                $file->save();
            }
        }
    }
}
