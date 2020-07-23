<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDataCouncilAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('council_attendance', function (Blueprint $table) {
            $table->date('date_taken')->after('total_member_attendances');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('council_attendance', function (Blueprint $table) {
            $table->dropColumn('date_taken');
        });
    }
}
