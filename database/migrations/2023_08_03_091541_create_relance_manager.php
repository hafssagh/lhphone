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
        Schema::create('relance_manager', function (Blueprint $table) {
            $table->id();
            $table->string('company');
            $table->string('email');
            $table->string('nameClient')->nullable();
            $table->string('numClient')->nullable();
            $table->date('date_envoie')->nullable();
            $table->string('numDevie')->nullable();
            $table->string('object')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('relance_manager');
    }
};
