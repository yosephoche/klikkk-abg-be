<?php

use Illuminate\Database\Seeder;
use App\Models\TahapPengajuanPengujian;
use Illuminate\Support\Str;

class TahapPengajuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('tahap_pengajuan_pengujian')->insert([
            [
                'uuid' => Str::uuid(),
                'nama' => 'Verifikasi Kepala Balai',
                'urutan' => 1,
                'pic' => 2,
            ],
            [
                'uuid' => Str::uuid(),
                'nama' => 'Verifikasi Pengganti Kepala Balai',
                'urutan' => 2,
                'pic' => 2,
            ],
            [
                'uuid' => Str::uuid(),
                'nama' => 'Verifikasi Staf Teknis',
                'urutan' => 3,
                'pic' => 2,
            ],
            [
                'uuid' => Str::uuid(),
                'nama' => 'Verifikasi Kepala Bidang',
                'urutan' => 4,
                'pic' => 2,
            ],
            [
                'uuid' => Str::uuid(),
                'nama' => 'Persetujuan Pemohon',
                'urutan' => 5,
                'pic' => 2,
            ],
            [
                'uuid' => Str::uuid(),
                'nama' => 'Pengisian E-Billing Bagian Keuangan',
                'urutan' => 6,
                'pic' => 2,
            ],
            [
                'uuid' => Str::uuid(),
                'nama' => 'Konfirmasi Pembayaran Pemohon',
                'urutan' => 7,
                'pic' => 2,
            ],
            [
                'uuid' => Str::uuid(),
                'nama' => 'Konfirmasi Pembayaran Oleh Bagian Keuangan',
                'urutan' => 8,
                'pic' => 2,
            ],
            [
                'uuid' => Str::uuid(),
                'nama' => 'Penunjukan personel pengujian oleh kepala bidang',
                'urutan' => 9,
                'pic' => 2,
            ],

        ]);
    }
}
