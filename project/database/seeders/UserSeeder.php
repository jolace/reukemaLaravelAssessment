<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = new User();
        $user->name = 'Jane';
        $user->email = 'jane@example.org';
        $user->password = \Hash::make('Secret!');
        $user->save();
        $user->assignRole('manager');

        $user = new User();
        $user->name = 'Jim';
        $user->email = 'jim@example.org';
        $user->password = \Hash::make('Secret!');
        $user->save();
        $user->assignRole('representative');

        $user = new User();
        $user->name = 'John';
        $user->email = 'john@example.org';
        $user->password = \Hash::make('Secret!');
        $user->save();
        $user->assignRole('representative');
    }
}
