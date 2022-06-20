<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Color::create(['name' => 'Black']);
        Color::create(['name' => 'White']);
        Color::create(['name' => 'Red']);
        Color::create(['name' => 'Green']);
    }
}
