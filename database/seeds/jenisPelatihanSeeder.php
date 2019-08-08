<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class jenisPelatihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jenis_pelatihan')->insert([
            'uuid' => STR::uuid(),
            'parameter' => 'Pelatihan Paramedis',
            'durasi' => 60,
            'biaya' => '2000000',
            'status' => '1',
        ]);

        DB::table('jenis_pelatihan')->insert([
            'uuid' => STR::uuid(),
            'parameter' => 'Pelatihan Dokter',
            'durasi' => 80,
            'biaya' => '3000000',
            'status' => '1',
        ]);
    }
}
