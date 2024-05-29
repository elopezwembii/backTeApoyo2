<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class DatabaseBackUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filename = "storage/app/backup/backupDB-" . Carbon::now()->format('Y-m-d') . ".sql";

        $command = "mysqldump " . env('DB_DATABASE') . " --port=" . env('DB_PORT') . " --user=" . env('DB_USERNAME') . " --password=" . env('DB_PASSWORD') . " > " . $filename;

        $returnVar = NULL;
        $output  = NULL;


        exec($command, $output, $returnVar);
    }
}
