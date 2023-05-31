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
                'first_name' => 'HICHAM',
                'last_name' => 'EL MESSIOUI',
                'email' => 'superadmin@gmail.com',
                'password' => bcrypt('superadmin'),
                'id_card'=> 'EE88479',
                'phone'=> '0648813816',
                'birthday'=> '1990-01-01',
                'date_contract'=> '2021-05-17',
                'type_contract'=> 'CDD',
                'company'=> 'h2f',
                'base_salary'=> '0',
            ],
            [
                'id' => '2',
                'first_name' => 'Ezzahra',
                'last_name' => 'ELMOURABIT',
                'email' => 'nada.lhphone@gmail.com',
                'password' => bcrypt('manager'),
                'id_card'=> 'EE88479',
                'phone'=> '0697726285',
                'birthday'=> '1990-01-01',
                'date_contract'=> '2021-11-08',
                'type_contract'=> 'CDD',
                'duration_contract'=> '8',
                'company'=> 'h2f',
                'base_salary'=> '10000',
            ],
            [
                'id' => '3',
                'first_name' => 'Chris Axel',
                'last_name' => 'Bélanger',
                'email' => 'chris.lhphone@gmail.com',
                'password' => bcrypt('manager'),
                'id_card'=> 'EE88479',
                'phone'=> '0602806937',
                'birthday'=> '1990-01-01',
                'date_contract'=> '2021-04-02',
                'type_contract'=> 'CDD',
                'duration_contract'=> '8',
                'base_salary'=> '10000',
                'company'=> 'lh',
            ],
            [
                'id' => '4',
                'first_name' => 'Hanane',
                'last_name' => 'Hdimane',
                'email' => 'Hanane.H2Fpremium@gmail.com',
                'password' => bcrypt('manager'),
                'id_card'=> 'EE88479',
                'phone'=> '0648813816',
                'birthday'=> '1990-01-01',
                'date_contract'=> '2021-05-17',
                'type_contract'=> 'CDD',
                'duration_contract'=> '8',
                'base_salary'=> '10000',
                'company'=> 'h2f',
            ],
            [
                'id' => '5',
                'first_name' => 'Amine',
                'last_name' => 'Manager',
                'email' => 'manager@gmail.com',
                'password' => bcrypt('manager'),
                'id_card'=> 'EE88479',
                'phone'=> '0648813816',
                'birthday'=> '1990-01-01',
                'date_contract'=> '2021-05-17',
                'type_contract'=> 'CDD',
                'duration_contract'=> '8',
                'base_salary'=> '10000',
                'company'=> 'lh',
            ],
            [
                'id' => '6',
                'first_name' => 'Mahdi',
                'last_name' => 'IBN ELARYF',
                'email' => 'Mehdi.lhphone@gmail.com',
                'password' => bcrypt('admin'),
                'id_card'=> 'EE88479',
                'phone'=> '0659656100',
                'birthday'=> '1990-01-01',
                'date_contract'=> '2021-05-17',
                'type_contract'=> 'CDD',
                'duration_contract'=> '8',
                'company'=> 'h2f',
                'base_salary'=> '6000',
            ],
            [
                'id' => '7',
                'first_name' => 'Hafssa',
                'last_name' => 'Ghalbane',
                'email' => 'hafssa.ghalbane@gmail.com',
                'password' => bcrypt('admin'),
                'id_card'=> 'EE88479',
                'phone'=> '0648813816',
                'birthday'=> '2000-05-08',
                'date_contract'=> '2023-05-17',
                'type_contract'=> 'CDD',
                'duration_contract'=> '8',
                'company'=> 'lh',
                'base_salary'=> '6000',
            ],

        ]); 
    }
}
