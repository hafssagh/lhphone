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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('state');
            $table->integer('dep');
            $table->date('date_prise');
            $table->date('date_confirm');
            $table->date('date_rdv');
            $table->time('cr');
            $table->string('prospect');
            $table->string('num_fix')->nullable();
            $table->string('num_mobile')->nullable();
            $table->string('adresse');
            $table->string('commentaire')->nullable();
            $table->string('retour')->nullable();
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
        Schema::dropIfExists('appointments');
    }
};
