<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("users")->insert([
            "Nombres" => "Admin",
            "Apellidos" => "Sistema",
            "Telefono" => "961138691",
            "Correo" => "admin@gmail.com",
            "Username" => "admin",
            "Password" => Hash::make("admin"),
            "EsAdmin" => true,
            "EsVerificado" => true,
        ]);
    }
}
