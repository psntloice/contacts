<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contacts;
use App\Models\Groups;

class ContactGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Assuming each contact will be assigned to 2 random groups
        $contacts = Contacts::all();
        $groups = Groups::all();

        foreach ($contacts as $contact) {
            // Get 2 random groups
            $randomGroups = $groups->random(2);
            foreach ($randomGroups as $group) {
                // Attach contact to the group
                $contact->groups()->attach($group->id);
            }
        }
    }
}
