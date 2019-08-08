<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JenisAkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jenis_akun = [
            [
                'uuid' => Str::uuid(),
                'nama' => 'BBPK3'
            ],[
                'uuid' => Str::uuid(),
                'nama' => 'Pengawas'
            ],[
                'uuid' => Str::uuid(),
                'nama' => 'Konsultan'
            ],[
                'uuid' => Str::uuid(),
                'nama' => 'Pemilik Usaha'
            ],[
                'uuid' => Str::uuid(),
                'nama' => 'Karyawan'
            ],[
                'uuid' => Str::uuid(),
                'nama' => 'Mahasiswa'
            ]
        ];

        DB::table('jenis_akun')->insert($jenis_akun);
    }
}
