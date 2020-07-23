<?php

namespace App\Console\Commands;

use App\Branch;
use Illuminate\Console\Command;

class PopulateMemberAvgForBranches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'branch:populate_member_avg_for_branches';

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
        $memberavgs = storage_path('app/public/files/branch_members.csv');
        $row = 0;

        if (($handle = fopen($memberavgs, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $row++;
                if ($row === 1) continue;

                Branch::where('id', $data[0])->update([
                    'membership_avg' => $data[2]
                ]);

                echo "{$row}. {$data[0]} {$data[1]}\n";
            }
        }
        fclose($handle);
    }
}
