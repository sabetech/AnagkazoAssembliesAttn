<?php

namespace App\Console\Commands;

use App\Shepherd;
use Illuminate\Console\Command;

class PopulateShepherdsBranchID extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shepherds:populate_shepherd_branch_id';

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
     * @return mixed
     */
    public function handle()
    {
        //
        $shepherd_branches = storage_path('app/public/files/shepherds_santa_maria.csv');
        $row = 0;

        if (($handle = fopen($shepherd_branches, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $row++;
                if ($row === 1) continue;

                Shepherd::create([
                    'shepherd_name' => $data[0],
                    'branch_id' => $data[2],
                    'council_id' => $data[3]
                ]);

                echo "{$row}. {$data[0]} {$data[1]}\n";
            }
        }
        fclose($handle);
    }
}
