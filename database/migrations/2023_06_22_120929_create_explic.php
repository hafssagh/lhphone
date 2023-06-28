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
        Schema::create('explic', function (Blueprint $table) {
            $table->id();
            $table->string('nameClient')->nullable();
            $table->string('emailClient')->unique();
            $table->string('numClient');
            $table->string('adresse')->nullable();
            $table->string('company');
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
        Schema::dropIfExists('explic');
    }
};
