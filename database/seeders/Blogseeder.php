<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];
        for ($i = 0; $i < 15; $i++) {
            $data[] = [
                'title' => Str::limit(fake()->sentence(5), 100),
                'description' => fake()->paragraph(3),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('blogs')->insert($data);
    }
}
