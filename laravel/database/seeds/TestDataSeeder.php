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
        DB::table('lcs')->delete();
        DB::table('events')->delete();
        DB::table('groups')->delete();
        DB::table('members')->delete();
        DB::table('event_members')->delete();

        // insert test data
        DB::table('lcs')->insert(
            array(
                [ 'id' => 1, 'city' => 'International', 'country' => 'Eestec' ],
                [ 'id' => 2, 'city' => 'Madrid', 'country' => 'Spain' ]
            )
        );

        DB::table('events')->insert(
            array(
                [ 'id' => 1, 'lc_id' => 1, 'name' => 'Testing Android Competition' ],
                [ 'id' => 2, 'lc_id' => 1, 'name' => 'Another Event' ]
            )
        );

        DB::table('groups')->insert(
            array(
                [ 'id' => 1, 'event_id' => 1, 'name' => 'Jury' ],
                [ 'id' => 2, 'event_id' => 1, 'name' => 'First Team' ],
                [ 'id' => 3, 'event_id' => 1, 'name' => 'Second Team' ],
                [ 'id' => 4, 'event_id' => 1, 'name' => 'Third Team' ]
            )
        );

        DB::table('members')->insert(
            array(
                [ 'id' => 1, 'first_name' => str_random(10), 'last_name' => str_random(10), 'birthdate' => date('Y-m-d H:i:s', rand(315532800, 788918400)), 'created_at' => new DateTime, 'email' => 'admin@test.pleem.local', 'password' => bcrypt('secret'), 'admin' => true ],
                [ 'id' => 2, 'first_name' => str_random(10), 'last_name' => str_random(10), 'birthdate' => date('Y-m-d H:i:s', rand(315532800, 788918400)), 'created_at' => new DateTime, 'email' => 'judge@test.pleem.local', 'password' => bcrypt('secret'), 'admin' => false ],
                [ 'id' => 3, 'first_name' => str_random(10), 'last_name' => str_random(10), 'birthdate' => date('Y-m-d H:i:s', rand(315532800, 788918400)), 'created_at' => new DateTime, 'email' => 'participant@test.pleem.local', 'password' => bcrypt('secret'), 'admin' => false ],
                [ 'id' => 5, 'first_name' => str_random(10), 'last_name' => str_random(10), 'birthdate' => date('Y-m-d H:i:s', rand(315532800, 788918400)), 'created_at' => new DateTime, 'email' => str_random(10).'@test.pleem.local', 'password' => bcrypt('secret'), 'admin' => false ],
                [ 'id' => 6, 'first_name' => str_random(10), 'last_name' => str_random(10), 'birthdate' => date('Y-m-d H:i:s', rand(315532800, 788918400)), 'created_at' => new DateTime, 'email' => str_random(10).'@test.pleem.local', 'password' => bcrypt('secret'), 'admin' => false ],
                [ 'id' => 4, 'first_name' => str_random(10), 'last_name' => str_random(10), 'birthdate' => date('Y-m-d H:i:s', rand(315532800, 788918400)), 'created_at' => new DateTime, 'email' => str_random(10).'@test.pleem.local', 'password' => bcrypt('secret'), 'admin' => false ],
                [ 'id' => 7, 'first_name' => str_random(10), 'last_name' => str_random(10), 'birthdate' => date('Y-m-d H:i:s', rand(315532800, 788918400)), 'created_at' => new DateTime, 'email' => str_random(10).'@test.pleem.local', 'password' => bcrypt('secret'), 'admin' => false ],
                [ 'id' => 8, 'first_name' => str_random(10), 'last_name' => str_random(10), 'birthdate' => date('Y-m-d H:i:s', rand(315532800, 788918400)), 'created_at' => new DateTime, 'email' => str_random(10).'@test.pleem.local', 'password' => bcrypt('secret'), 'admin' => false ],
            )
        );

        DB::table('event_members')->insert(
            array(
                // Jury
                [ 'member_id' => 1, 'event_id' => 1, 'group_id' => 1, 'role' => App\Member::ROLE_JUDGE ],
                [ 'member_id' => 2, 'event_id' => 1, 'group_id' => 1, 'role' => App\Member::ROLE_JUDGE ],

                // Participants, in teams
                [ 'member_id' => 3, 'event_id' => 1, 'group_id' => 2, 'role' => App\Member::ROLE_PARTICIPANT ],
                [ 'member_id' => 4, 'event_id' => 1, 'group_id' => 2, 'role' => App\Member::ROLE_PARTICIPANT ],
                [ 'member_id' => 5, 'event_id' => 1, 'group_id' => 3, 'role' => App\Member::ROLE_PARTICIPANT ],
                [ 'member_id' => 6, 'event_id' => 1, 'group_id' => 3, 'role' => App\Member::ROLE_PARTICIPANT ],
                [ 'member_id' => 7, 'event_id' => 1, 'group_id' => 4, 'role' => App\Member::ROLE_PARTICIPANT ],
                [ 'member_id' => 8, 'event_id' => 1, 'group_id' => 4, 'role' => App\Member::ROLE_PARTICIPANT ],
            )
        );
    }
}
