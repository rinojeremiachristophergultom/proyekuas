<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Admin ::create([
            'name' => 'cibecibe',
            'email' => 'cibsbae@gmail.com',
            'username' =>'cibebae',
            'password' => bcrypt('cibe12345'),
        ]);
    }
}
