<?php

use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // wipe previous data
        DB::table('groups')->delete();
        DB::table('members')->delete();
        DB::table('scores')->delete();
        DB::table('ideas')->delete();

        // insert test data
        DB::table('groups')->insert(
            array(
                [ 'id' => 1, 'name' => 'First Team' ],
                [ 'id' => 2, 'name' => 'Second Team' ],
                [ 'id' => 3, 'name' => 'Third Team' ]
            )
        );

        DB::table('members')->insert(
            array(
                [ 'id' => 1, 'country' => 'es', 'sex' => 'm', 'first_name' => str_random(10), 'last_name' => str_random(10), 'birthdate' => date('Y-m-d H:i:s', rand(315532800, 788918400)), 'created_at' => new DateTime, 'email' => 'admin@test.pleem.local', 'password' => bcrypt('secret'), 'admin' => true, 'judge' => false, 'group_id' => 1 ],
                [ 'id' => 2, 'country' => 'es', 'sex' => 'm', 'first_name' => str_random(10), 'last_name' => str_random(10), 'birthdate' => date('Y-m-d H:i:s', rand(315532800, 788918400)), 'created_at' => new DateTime, 'email' => 'judge@test.pleem.local', 'password' => bcrypt('secret'), 'admin' => false, 'judge' => true, 'group_id' => 1 ]
            )
        );

        DB::table('members')->insert(
            array(
                [ 'id' => 3, 'country' => 'es', 'sex' => 'm', 'first_name' => str_random(10), 'last_name' => str_random(10), 'birthdate' => date('Y-m-d H:i:s', rand(315532800, 788918400)), 'created_at' => new DateTime, 'email' => 'participant@test.pleem.local', 'password' => bcrypt('secret'), 'admin' => false, 'judge' => false, 'group_id' => 1 ],
                [ 'id' => 5, 'country' => 'es', 'sex' => 'f', 'first_name' => str_random(10), 'last_name' => str_random(10), 'birthdate' => date('Y-m-d H:i:s', rand(315532800, 788918400)), 'created_at' => new DateTime, 'email' => str_random(10).'@test.pleem.local', 'password' => bcrypt('secret'), 'admin' => false, 'judge' => false, 'group_id' => 1 ],
                [ 'id' => 6, 'country' => 'es', 'sex' => 'm', 'first_name' => str_random(10), 'last_name' => str_random(10), 'birthdate' => date('Y-m-d H:i:s', rand(315532800, 788918400)), 'created_at' => new DateTime, 'email' => str_random(10).'@test.pleem.local', 'password' => bcrypt('secret'), 'admin' => false, 'judge' => false, 'group_id' => 2 ],
                [ 'id' => 4, 'country' => 'es', 'sex' => 'f', 'first_name' => str_random(10), 'last_name' => str_random(10), 'birthdate' => date('Y-m-d H:i:s', rand(315532800, 788918400)), 'created_at' => new DateTime, 'email' => str_random(10).'@test.pleem.local', 'password' => bcrypt('secret'), 'admin' => false, 'judge' => false, 'group_id' => 2 ],
                [ 'id' => 7, 'country' => 'es', 'sex' => 'f', 'first_name' => str_random(10), 'last_name' => str_random(10), 'birthdate' => date('Y-m-d H:i:s', rand(315532800, 788918400)), 'created_at' => new DateTime, 'email' => str_random(10).'@test.pleem.local', 'password' => bcrypt('secret'), 'admin' => false, 'judge' => false, 'group_id' => 2 ],
                [ 'id' => 8, 'country' => 'es', 'sex' => 'm', 'first_name' => str_random(10), 'last_name' => str_random(10), 'birthdate' => date('Y-m-d H:i:s', rand(315532800, 788918400)), 'created_at' => new DateTime, 'email' => str_random(10).'@test.pleem.local', 'password' => bcrypt('secret'), 'admin' => false, 'judge' => false, 'group_id' => 3 ],
            )
        );
    }
}
