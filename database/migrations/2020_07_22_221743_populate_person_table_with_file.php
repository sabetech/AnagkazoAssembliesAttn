<?php

use App\Person;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PopulatePersonTableWithFile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        $person_data_branch_File = storage_path('app/public/files/person_branch_id_data_2020-07-22.csv');
        $row = 0;

        if (($handle = fopen($person_data_branch_File, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $row++;
                if ($row === 1) continue;
                Person::where('id', $data[0])->update(['branch_id' => $data[3]]);
            }
        }
        fclose($person_data_branch_File);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
