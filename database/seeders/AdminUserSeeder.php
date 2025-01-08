<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdminUser::create([
            'name' => 'Admin',
            'email' => '4car@mail.kz',
            'password' => Hash::make('agdepassword'), // Хэшируем пароль
            'role' => 'admin', // Если вы используете роли
        ]);
    }
}
