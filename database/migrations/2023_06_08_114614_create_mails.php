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
        Schema::create('mails', function (Blueprint $table) {
            $table->id();
            $table->string('nameClient');
            $table->string('emailClient')->unique();
            $table->string('numClient');
            $table->string('adresse');
            $table->string('company');
            $table->string('state')->nullable(); 
            $table->string('remark')->nullable(); 
            $table->string('remark2')->nullable(); 
            $table->string('rappel')->nullable();
            $table->string('send');  
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
        Schema::dropIfExists('table_mails');
    }
};
