<?php

namespace App\Console\CommandsBackup;

use Illuminate\Console\Command;
use App\Models\Error;

class RunParallelQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-parallel-queue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run multiple queue workers in parallel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $workers = 10;

        for ($i = 0; $i < $workers; $i++) {

            $command = 'php ' . base_path('artisan') . ' queue:work --queue=institute_pdf_process --once';

            // echo strtoupper(substr(PHP_OS, 0, 3));

            // echo "\n\n";

            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                pclose(popen("start /B $command", "r"));
                echo "start /B $command";
            } else {
                exec("$command > /dev/null 2>&1 &");
                // echo "$command > /dev/null 2>&1 &";
            }

            // echo "\n\n";
        }

        $this->info("Started {$workers} queue workers.");
    }
}
