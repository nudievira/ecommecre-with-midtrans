<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $admin_account = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'phone' => '081122334455',
            'email' => 'admin@konco.com',
            'password'=> bcrypt('admin123')
        ]);

        $admin_account->assignRole('admin');

        $customer_account = User::create([
            'name' => 'Customer',
            'username' => 'customer',
            'phone' => '081122334455',
            'email' => 'customer@konco.com',
            'password'=> bcrypt('customer123')
        ]);

        $customer_account->assignRole('customer');

    }
}
