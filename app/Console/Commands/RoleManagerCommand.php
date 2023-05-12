<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Role;
use Ramsey\Uuid\Uuid;

use Illuminate\Support\Facades\File;

class RoleManagerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role-manager:run {--drop-table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command makes the missing roles';

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
        echo "ROLE MANAGER COMMAND CONSOLE. \n";

        // Fetch the roles data
        echo "Fetch Roles Data \n";
        $rolesArray = json_decode(File::get(resource_path('json/roles.json')), true);
        echo "Roles Data Fetched \n\n";

        // Delete or update table
        if ($this->option('drop-table')) {
            echo "--drop-table=true : ----\n";
            echo "Dropping all rows\n";
            Role::truncate();
            echo "Rows dropped\n";
        } else {
            echo "Skipping Drop tables\n";
        }
        echo "\n";

        // Adding / Updating rows
        echo "Mutating Data-----------------------------\n";
        foreach ($rolesArray as $role) {
            Role::firstOrCreate($role, ['uuid' => Uuid::uuid4()]);
            echo "Role: {$role['admin']}\n";
        } //end foreach
        echo "Data Mutated------------------------------\n";
    } //end method handle
}//end class RoleManagerCommand
