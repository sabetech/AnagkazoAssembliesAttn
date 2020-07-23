<?php

namespace App\Console\Commands;

use App\Branch;
use Illuminate\Console\Command;

class update_branch_pastor_field extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'branch:update_branch_pastor_field_from_file';

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
        $branch_pastors = storage_path('app/public/files/branch_pastors.csv');
        $row = 0;

        if (($handle = fopen($branch_pastors, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $row++;
                if ($row === 1) continue;

                Branch::where('id', $data[3])->update(['person_id' => $data[0]]);
                echo "{$row}. {$data[0]} {$data[2]}\n";
            }
        }
        fclose($handle);
    }
}
