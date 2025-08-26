<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    public function run()
    {
        Item::create(['name' => 'John Doe', 'type' => 'mentors']);
        Item::create(['name' => 'Startup X', 'type' => 'startups']);
        Item::create(['name' => 'Tech Event', 'type' => 'events']);
        Item::create(['name' => 'Big Partner', 'type' => 'partners']);
    }
}

