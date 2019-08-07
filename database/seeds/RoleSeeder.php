<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Role();
        $admin->name = 'admin';
        $admin->display_name = 'Administrator';
        $admin->description = 'Admin K3';
        $admin->save();

        $user = new Role();
        $user->name = 'user';
        $user->display_name = 'User';
        $user->description = 'User Klikkk ABG';
        $user->save();

        $kepalaBalai = new Role();
        $kepalaBalai->name = 'kepala_balai';
        $kepalaBalai->display_name = 'Kepala Balai K3';
        $kepalaBalai->description = 'Kepala balai k3';
        $kepalaBalai->save();

        $penggantiKepalBalai = new Role();
        $penggantiKepalBalai->name = 'pengganti_kepala_balai';
        $penggantiKepalBalai->display_name = 'Pengganti Kepala balai K3';
        $penggantiKepalBalai->description = 'Pengganti Kepala balai k3 apabila kepala balai tidak di tempat';
        $penggantiKepalBalai->save();

        $staffTeknis = new Role();
        $staffTeknis->name = 'staf_teknis';
        $staffTeknis->display_name = 'Staff Teknis K3';
        $staffTeknis->description = 'Staff teknis k3';
        $staffTeknis->save();

        // $kepalaBagian = new Role();
        // $kepalaBagian->name = 'kepala_bagian';
        // $kepalaBagian->display_name = 'Kepala Bagian K3';
        // $kepalaBagian->description = 'Kepala Bagian K3';
        // $kepalaBagian->save();

        // $keuangan = new Role();
        // $keuangan->name = 'keuangan';
        // $keuangan->display_name = 'Staf Keuangan K3';
        // $keuangan->description = 'Bagian keuangan k3';
        // $keuangan->save();

        // $kepalaPenguji = new Role();
        // $kepalaPenguji->name = 'kepala_penguji';
        // $kepalaPenguji->display_name = 'Kepala Penguji K3';
        // $kepalaPenguji->description = 'Kepala Penguji teknis k3';
        // $kepalaPenguji->save();

        // $staffPenguji = new Role();
        // $staffPenguji->name = 'staf_penguji';
        // $staffPenguji->display_name = 'Staf Penguji K3';
        // $staffPenguji->description = 'Staf K3 yang melakukan pengujian';
        // $staffPenguji->save();
    }
}
