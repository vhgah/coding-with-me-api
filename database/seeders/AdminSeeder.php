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
                'password' => Hash::make('Matkhau123@'),
                'status' => AdminStatusEnum::ACTIVE
            ]
        );
    }
}
