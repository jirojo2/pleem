<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('judge_id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->boolean('public');
            $table->string('name');
            $table->float('score');
            $table->timestamps();

            $table->foreign('judge_id')
                ->references('id')->on('members')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('group_id')
                ->references('id')->on('groups')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('scores');
    }
}
