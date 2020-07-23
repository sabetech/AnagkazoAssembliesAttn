<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMemberAvgToCouncilBranches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('council_branches', function (Blueprint $table) {
            //
            $table->integer('membership_avg')->after('person_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('council_branches', function (Blueprint $table) {
            //
            $table->dropColumn('membership_avg');
        });
    }
}
