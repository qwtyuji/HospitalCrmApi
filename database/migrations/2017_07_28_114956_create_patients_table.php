<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('姓名')->nullable();
            $table->string('sex')->comment('性别')->nullable();
            $table->string('phone')->comment('电话')->nullable();
            $table->string('age')->comment('年龄')->nullable();
            $table->string('doctor_id')->comment('医生')->nullable();
            $table->string('user_id')->comment('用户');
            $table->string('hospital_id')->comment('医院');
            $table->string('department_id')->comment('科室')->nullable();
            $table->string('disease_id')->comment('疾病')->nullable();
            $table->string('depart_id')->comment('部门');
            $table->string('media_id')->comment('媒体');
            $table->string('area')->comment('地区')->nullable();
            $table->string('order_time')->comment('预约时间')->nullable();
            $table->string('status')->comment('状态')->default(0);
            $table->timestamps();
        });
        Schema::create('patient_content', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('patient_id')->comment('患者id');
            $table->unsignedInteger('user_id')->comment('用户id');
            $table->text('content')->comment('咨询内容')->nullable();
            $table->text('chat_record')->comment('聊天内容')->nullable();
            $table->timestamps();
        });
        Schema::create('patient_callback', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('patient_id')->comment('患者id');
            $table->unsignedInteger('user_id')->comment('用户id');
            $table->text('content')->comment('回访内容')->nullable();
            $table->timestamps();
        });
        Schema::create('patient_log', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('patient_id')->comment('患者id');
            $table->unsignedInteger('user_id')->comment('用户id');
            $table->text('content')->comment('操作记录')->nullable();
            $table->timestamps();
        });

        Schema::create('patient_remark', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('patient_id')->comment('患者id');
            $table->unsignedInteger('user_id')->comment('用户id');
            $table->text('content')->comment('备注内容')->nullable();
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
        Schema::dropIfExists('patients');
        Schema::dropIfExists('patient_content');
        Schema::dropIfExists('patient_callback');
        Schema::dropIfExists('patient_log');
        Schema::dropIfExists('patient_remark');
    }
}
