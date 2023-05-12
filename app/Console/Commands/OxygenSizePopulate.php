<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\OxygenSize;

class OxygenSizePopulate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'oxygen-populate:sizes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populates the oxygen_sizes table';

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
        echo "Running the oxygen size populate\n";

        $sizes = [
            ['size' => 2],
            ['size' => 6],
            ['size' => 7],
            ['size' => 7.5],
            ['size' => 10],
        ];

        foreach($sizes as $size){
            OxygenSize::firstOrCreate(['size' => $size['size']]);
        }//end foreach

        echo "Oxygen sizes in sync. \n";
    }//end mathod handle
}//end class OxygenSizePopulate
