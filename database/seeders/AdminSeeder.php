<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Enums\AdminStatusEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::updateOrCreate(
            [
                'email' => 'admin@gmail.com',
            ],
            [
                'password' => Hash::make('123456'),
                'status' => AdminStatusEnum::ACTIVE
            ]
        );
    }
}
