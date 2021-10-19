<?php

namespace App\Console\Commands;

use App\Imports\BDEImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
class ImportBDE extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bde:import';
    protected $path = 'app/Imports/BDE.xlsx';
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
        Excel::import(new BDEImport(), $this->path);
        return 0;
    }
}
