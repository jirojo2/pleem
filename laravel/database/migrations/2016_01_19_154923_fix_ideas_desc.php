<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixIdeasDesc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ideas', function ($table) {
            $table->dropColumn(['modules', 'platform']);
        });

        DB::statement('ALTER TABLE ideas MODIFY `description` MEDIUMTEXT;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ideas', function ($table) {
            $table->string('modules');
            $table->string('platform');

            DB::statement('ALTER TABLE ideas MODIFY `description` VARCHAR(255);');
        });
    }
}
