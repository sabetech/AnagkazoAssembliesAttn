<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraColumnToCouncilAttendance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('council_attendance', function (Blueprint $table) {
            //
            $table->unsignedInteger('council_id')->after('id');
            $table->unsignedInteger('branch_id')->after('council_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('council_attendance', function (Blueprint $table) {
            //
            $table->dropColumn('council_id');
            $table->dropColumn('branch_id');
        });
    }
}
