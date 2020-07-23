<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBranchIdToShepherdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shepherds', function (Blueprint $table) {
            //
            $table->unsignedInteger('branch_id')->after('shepherd_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shepherds', function (Blueprint $table) {
            //
            $table->dropColumn('branch_id');
        });
    }
}
