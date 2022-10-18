<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'firstname' => 'Admin',
            'lastname' => '01',
            'address' => 'De La Salle-College of Saint Benilde Manila',
            'phone' => '0',
            'email' => 'SkyCems@admin.com',
            'password' => bcrypt('Admin123.'),
            'terms_and_conditions' =>'Agree',
            'status' => true,
            'role' => 'admin',
        ]);
    }
}
