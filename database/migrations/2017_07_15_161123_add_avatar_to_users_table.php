<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAvatarToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedInteger('hospital_id');
            $table->unsignedInteger('depart_id');
            $table->unsignedInteger('is_depart_admin')->default(0);
            $table->unsignedInteger('is_hospital_admin')->default(0);
            $table->unsignedInteger('is_admin')->default(0);
            $table->ipAddress('ip')->nullable();
            $table->time('last_login_time')->nullable();
            $table->unsignedInteger('login_time')->nullable();
            $table->string('device')->nullable();
            $table->string('resolution')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar');
            $table->dropColumn('phone');
            $table->dropColumn('status');
            $table->dropColumn('hospital_id');
            $table->dropColumn('depart_id');
            $table->dropColumn('ip');
            $table->dropColumn('last_login_time');
            $table->dropColumn('login_time');
            $table->dropColumn('device');
            $table->dropColumn('resolution');
            $table->dropColumn('is_depart_admin');
            $table->dropColumn('is_hospital_admin');
            $table->dropColumn('is_admin');
        });
    }
}
