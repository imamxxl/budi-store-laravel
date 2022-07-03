<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nama' => 'Imam Ahmad',
            'username' => 'PP222',
            'password' => bcrypt('123456'),
            'jk' => 'Laki-laki',
            'level' => 'pimpinan',
            'avatar' => 'default.jpg',
            'created_at' => '2022-07-02 00:02:35',
            'updated_at' => '2022-07-02 00:02:35',
        ]);
    }
}
