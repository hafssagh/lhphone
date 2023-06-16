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
            $table->int('un')->nullable();
            $table->int('deux')->nullable();
            $table->int('trois')->nullable();
            $table->int('cinq')->nullable();
            $table->int('dix')->nullable();
            $table->int('hublots')->nullable();
            $table->int('reglette')->nullable();
            $table->int('pommeaux')->nullable();
            $table->int('mousseurs')->nullable();
            $table->int('tube')->nullable();
            $table->int('spot')->nullable();
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
