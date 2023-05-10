<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'id' => '1',
                'name'=>'superadmin'
            ],
            [
                'id' => '2',
                'name'=>'Administrateur'
            ],
            [
                'id' => '3',
                'name'=>'Manager'
            ],
            [
                'id' => '4',
                'name'=>'Agent'
            ],

        ]);
    }
}
