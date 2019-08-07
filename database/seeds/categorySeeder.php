<?php

use Illuminate\Database\Seeder;

class categorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('forum_categories')->insert([
            'name' => 'Balai Besar PK3 Makassar',
            'description' => 'Balai Besar PK3 Makassar',
        ]);

        DB::table('forum_categories')->insert([
            'name' => 'Peraturan K3',
            'description' => 'Peraturan K3',
        ]);

        DB::table('forum_categories')->insert([
            'name' => 'Berita K3',
            'description' => 'Berita K3',
        ]);

        DB::table('forum_categories')->insert([
            'name' => 'Promosi K3',
            'description' => 'Promosi K3',
        ]);

        DB::table('forum_categories')->insert([
            'name' => 'Lain-Lain',
            'description' => 'Lain-Lain',
        ]);

        DB::table('forum_categories')->insert([
            'name' => 'FAQ',
            'description' => 'FAQ',
        ]);
    }
}
