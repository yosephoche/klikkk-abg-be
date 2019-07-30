<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class threadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('forum_topic')->insert([
            'created_by' => 1,
            'category_id'=>1,
            'subject' => 'threads 1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('forum_topic')->insert([
            'created_by' => 1,
            'category_id'=>1,
            'subject' => 'threads 2',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('forum_topic')->insert([
            'created_by' => 1,
            'category_id'=>1,
            'subject' => 'threads 3',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('forum_topic')->insert([
            'created_by' => 2,
            'category_id'=>1,
            'subject' => 'threads 4',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('forum_topic')->insert([
            'created_by' => 2,
            'category_id'=>1,
            'subject' => 'threads 5',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
