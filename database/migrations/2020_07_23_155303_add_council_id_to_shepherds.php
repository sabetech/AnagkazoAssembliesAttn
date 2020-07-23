<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCouncilIdToShepherds extends Migration
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
            $table->unsignedInteger('council_id')->after('branch_id');
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
            $table->dropColumn('council_id');
        });
    }
}
