<?php

namespace App\Console\Commands;

use App\Person;
use Illuminate\Console\Command;

class populate_person_table_with_file extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'person:update_branch_ids';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command updates branch ids of persons';

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
        $person_data_branch_File = storage_path('app/public/files/person_branch_id_data_2020-07-22.csv');
        $row = 0;

        if (($handle = fopen($person_data_branch_File, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $row++;
                if ($row === 1) continue;

                Person::where('id', $data[0])->update(['branch_id' => $data[3]]);
                echo "{$row}. {$data[0]} {$data[2]}\n";
            }
        }
        fclose($handle);
    }
}
