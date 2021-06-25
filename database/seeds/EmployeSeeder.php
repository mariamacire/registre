<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class EmployeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'mariama',
            'email' => 'cirediallo@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
