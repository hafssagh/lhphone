<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('id_card')->nullable();
            $table->string('phone')->nullable();
            $table->date('birthday')->nullable();
            $table->date('date_contract')->nullable();
            $table->string('type_contract');
            $table->string('duration_contract')->nullable();
            $table->string('type_virement')->nullable();
            $table->string('rib')->nullable();
            $table->string('company');
            $table->string('group')->nullable();
            $table->double('base_salary')->nullable();
            $table->integer('work_hours')->nullable();
            $table->double('salary')->nullable();
            $table->double('challenge')->nullable();
            $table->double('prime')->nullable();
            $table->string('photo')->nullable();
            $table->string('nom_prod')->nullable();
            $table->integer('objectif')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
