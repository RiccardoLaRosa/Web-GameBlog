<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void {
        Tag::create(['message'=>'New Relase']);
        Tag::create(['message'=>'DLC']);
        Tag::create(['message'=>'Most Viewed']);
    }
}
