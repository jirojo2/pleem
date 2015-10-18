<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_members', function (Blueprint $table) {
            $table->integer('event_id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->integer('member_id')->unsigned();

            $table->enum('role', [
                App\Member::ROLE_APPLICANT,
                App\Member::ROLE_PARTICIPANT,
                App\Member::ROLE_JUDGE,
                App\Member::ROLE_ORGANIZER,
                App\Member::ROLE_ADMIN,
            ]);

            // Timestamps for curiosity
            $table->timestamps();

            // Primary key
            $table->primary(['event_id', 'group_id', 'member_id']);

            // Foreign keys
            $table->foreign('event_id')
                ->references('id')->on('events')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('group_id')
                ->references('id')->on('groups')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('member_id')
                ->references('id')->on('members')
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
        Schema::drop('event_members');
    }
}
