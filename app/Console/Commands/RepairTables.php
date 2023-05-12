<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\OxygenRequest;

use App\Rider;
use Illuminate\Support\Facades\Hash;

class RepairTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repair:tables';

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
        // echo "Repairing the Oxygen Requests Table\n";

        // $this->call("migrate");
        // echo "...\n";

        // $oxygenRequests = OxygenRequest::where('status', OxygenRequest::STATUS['PICKED-UP'])->get();

        // foreach ($oxygenRequests as $o) {
        //     $o->pickupDate = $o->updated_at;
        //     $o->save();
        // }

        // echo "Oxygen Requests Table Repaired.\n";

        echo "Repairing the Riders Table\n";

        $this->call("migrate");
        echo "...\n";

        Rider::all()->each(function ($rider) {
            if (!$rider->password) {
                $rider->password = Hash::make('password');
                $rider->save();
            }
        });
        echo "Riders Table Repaired.\n";
    } //end method handle
}
