<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Groups;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        for ($i = 0; $i < 5; $i++) {
            Groups::create([
                'group_name' => 'Group' . $i,
                'description' => 'Description for group ' . $i,
            ]);
        }
    }
}
