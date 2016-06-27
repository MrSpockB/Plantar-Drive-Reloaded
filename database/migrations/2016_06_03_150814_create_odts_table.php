<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOdtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->date('creationDate');
            $table->string('area');
            $table->text('description');
            $table->date('startDate');
            $table->date('endDate');
            $table->decimal('progress_estimated');
            $table->decimal('progress_real');
            $table->string('status');
            $table->integer('client_id');
            $table->integer('user_id');
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
        Schema::drop('odts');
    }
}
