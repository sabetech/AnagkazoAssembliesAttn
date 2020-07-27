<?php

namespace App\Console\Commands;

use App\Shepherd;
use Illuminate\Console\Command;

class populate_shepherds_table extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shepherds:populate_shepherds_table_from_file {shepherd_pastor_file}';

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
        $shepherd_pastor_file = $this->argument('shepherd_pastor_file');
        $person_data_branch_File = storage_path("app/public/files/{$shepherd_pastor_file}.csv");
        $row = 0;

        if (($handle = fopen($person_data_branch_File, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $row++;
                if ($row === 1) continue;

                Shepherd::create([
                    'shepherd_name' => $data[0],
                    'person_id' => $data[2],
                    'council_id' => $data[3]
                ]);

                echo "{$row}. {$data[0]} {$data[1]}\n";
            }
        }
        fclose($handle);
    }
}
