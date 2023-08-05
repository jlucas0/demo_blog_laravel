<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SQLiteDatabaseGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:sqlite-generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates fresh sqlite database into database folder';

    /**
     * Execute the console command.
     */
    public function handle() : int
    {
        $status = 0;
        $path = database_path()."/database.sqlite";


        try{

            file_put_contents($path, "");

            $this->info("Database created at ".$path);

        }catch(\Exception $e){
            $this->error($e->getMessage());
            $status = -1;
        }


        return $status;
    }
}
