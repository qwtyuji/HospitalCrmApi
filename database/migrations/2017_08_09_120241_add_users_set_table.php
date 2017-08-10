<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsersSetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_sets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('default_hospital_id')->nullable();
            $table->json('hospital_ids')->nullable();
            $table->unsignedInteger('depart_id')->nullable();
            $table->unsignedInteger('is_depart_admin')->default(0);
            $table->unsignedInteger('is_hospital_admin')->default(0);
            $table->unsignedInteger('is_admin')->default(0);
            $table->ipAddress('ip')->nullable();
            $table->timestamp('last_login_time')->nullable();
            $table->unsignedInteger('login_time')->nullable();
            $table->string('device')->nullable();
            $table->string('resolution')->nullable();
            $table->json('patient_column')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_sets');
    }
}
