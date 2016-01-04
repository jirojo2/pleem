<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RepoIdea extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groups', function ($table) {
            $table->dropColumn(['repository']);
        });
        Schema::table('ideas', function ($table) {
            $table->string('repository');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ideas', function ($table) {
            $table->dropColumn(['repository']);
        });
        Schema::table('groups', function ($table) {
            $table->string('repository');
        });
    }
}
