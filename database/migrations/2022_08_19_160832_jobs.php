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
        Schema::create('jobs', function(Blueprint $table) {
          $table->bigIncrements('id');
          $table->foreignId('user_id')->constrained()->onDelete('cascade');
          $table->string('title')->nullable();
          $table->longText('description')->nullable();
          $table->string('companyName')->nullable();
          $table->string('type')->nullable();
          $table->string('skills')->nullable();
          $table->integer('salary')->nullable();
          $table->string('salary_interval')->nullable();
          $table->string('close_date')->nullable();
          $table->integer('close_time')->nullable();
          $table->longText('qualifications')->nullable();
          $table->integer('hidden')->nullable();
          
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
        //
    }
};
