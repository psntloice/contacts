<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contacts;

class ContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Manually create 10 contact records
        for ($i = 0; $i < 10; $i++) {
            Contacts::create([
                'first_name' => 'First' . $i,
                'last_name' => 'Last' . $i,
                'email' => 'user' . $i . '@example.com',
                'phone_number' => '123-456-789' . $i,
                'address' => '123 Main St, City, Country',
            ]);
        }
    }
}
