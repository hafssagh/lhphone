<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(UserTableSeeder::class);
        $this->call(RoleTableSeeder::class);


        User::find(1)->roles()->attach(1);
        User::find(2)->roles()->attach(3);
        User::find(3)->roles()->attach(3);
        User::find(4)->roles()->attach(3);
        User::find(5)->roles()->attach(3);
        User::find(6)->roles()->attach(2);
        User::find(7)->roles()->attach(2);
        User::find(8)->roles()->attach(4);
        User::find(9)->roles()->attach(4);
        User::find(10)->roles()->attach(4);
        User::find(11)->roles()->attach(4);
        User::find(12)->roles()->attach(4);
        User::find(13)->roles()->attach(4);
        User::find(14)->roles()->attach(4);
        User::find(16)->roles()->attach(4);
        User::find(17)->roles()->attach(4);
        User::find(18)->roles()->attach(4);
        User::find(19)->roles()->attach(4);
        User::find(20)->roles()->attach(4);
        User::find(21)->roles()->attach(4);
        User::find(22)->roles()->attach(4);
        User::find(23)->roles()->attach(4);
        User::find(24)->roles()->attach(4);
        User::find(26)->roles()->attach(4);
        User::find(27)->roles()->attach(4);
        User::find(28)->roles()->attach(4);
        User::find(30)->roles()->attach(4);
        User::find(31)->roles()->attach(4);
        User::find(32)->roles()->attach(4);
        User::find(33)->roles()->attach(4);
        User::find(34)->roles()->attach(4);
        User::find(35)->roles()->attach(4);
        User::find(36)->roles()->attach(4);
    }
}
