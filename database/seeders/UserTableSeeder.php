<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => '1',
                'first_name' => 'Alice',
                'last_name' => 'Tremblay',
                'email' => 'superadmin@gmail.com',
                'password' => bcrypt('superadmin'),
                'id_card'=> 'EE88479',
                'phone'=> '0648813816',
                'birthday'=> '2023-05-17',
                'date_contract'=> '2023-05-17',
                'type_contract'=> 'CDD',
                'duration_contract'=> '8',
                'base_salary'=> '6000',
                'salary'=> '6000',
            ],
            [
                'id' => '2',
                'first_name' => 'Hafssa',
                'last_name' => 'Ghalbane',
                'email' => 'hafssa.ghalbane@gmail.com',
                'password' => bcrypt('admin'),
                'id_card'=> 'EE88479',
                'phone'=> '0648813816',
                'birthday'=> '2023-05-17',
                'date_contract'=> '2023-05-17',
                'type_contract'=> 'CDD',
                'duration_contract'=> '8',
                'base_salary'=> '6000',
                'salary'=> '6000',
            ],
            [
                'id' => '3',
                'first_name' => 'Alexis',
                'last_name' => 'Bélanger',
                'email' => 'manager@gmail.com',
                'password' => bcrypt('manager'),
                'id_card'=> 'EE88479',
                'phone'=> '0648813816',
                'birthday'=> '2023-05-17',
                'date_contract'=> '2023-05-17',
                'type_contract'=> 'CDD',
                'duration_contract'=> '8',
                'base_salary'=> '6000',
                'salary'=> '6000',
            ],
            [
                'id' => '4',
                'first_name' => 'Antoine',
                'last_name' => 'Bergeron',
                'email' => 'agent@gmail.com',
                'password' => bcrypt('agent'),
                'id_card'=> 'EE88479',
                'phone'=> '0648813816',
                'birthday'=> '2023-05-17',
                'date_contract'=> '2023-05-17',
                'type_contract'=> 'CDD',
                'duration_contract'=> '8',
                'base_salary'=> '6000',
                'salary'=> '6000',
            ],
            [
                'id' => '5',
                'first_name' => 'Charlotte',
                'last_name' => 'Fortier',
                'email' => 'charlotte@gmail.com',
                'password' => bcrypt('charlot'),
                'id_card'=> 'EE88479',
                'phone'=> '0648813816',
                'birthday'=> '2023-05-17',
                'date_contract'=> '2023-05-17',
                'type_contract'=> 'CDD',
                'duration_contract'=> '8',
                'base_salary'=> '6000',
                'salary'=> '6000',
            ],

        ]);
    }
}
