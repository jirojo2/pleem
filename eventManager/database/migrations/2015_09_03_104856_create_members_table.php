<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id')->unsigned();

            $table->string('email')->unique();
            $table->string('password', 60);
            $table->boolean('admin')->default(false);
            $table->boolean('judge')->default(false);
            $table->rememberToken();
            $table->timestamps();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('country');
            $table->date('birthdate');
            $table->enum('sex', ['m', 'f']);

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
        Schema::drop('members');
    }
}
