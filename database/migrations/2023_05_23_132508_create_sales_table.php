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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->string('state');
            $table->date('date_sal');
            $table->date('date_confirm')->nullable();
            $table->string('name_client');
            $table->string('mail_client');
            $table->string('phone_client');
            $table->string('remark')->nullable();
            $table->integer('un')->nullable();
            $table->integer('deux')->nullable();
            $table->integer('trois')->nullable();
            $table->integer('cinq')->nullable();
            $table->integer('dix')->nullable();
            $table->integer('hublots')->nullable();
            $table->integer('reglette')->nullable();
            $table->integer('pommeaux')->nullable();
            $table->integer('mousseurs')->nullable();
            $table->integer('tube')->nullable();
            $table->integer('spot')->nullable();
            $table->string('commentaire')->nullable(); 
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
        Schema::dropIfExists('sales');
    }
};
