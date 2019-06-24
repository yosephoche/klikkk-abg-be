<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$jenis_akun = DB::table('jenis_akun')->pluck('id')->toArray();

$factory->define(User::class, function (Faker $faker) use ( $jenis_akun ) {
    return [
        'uuid' => Str::uuid(),
        'user_id' => $faker->creditCardNumber,
        'nama_lengkap' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'pekerjaan' => $faker->jobTitle,
        'instansi' => $faker->company,
        'no_telepon' => $faker->tollFreePhoneNumber,
        'jenis_akun' => Arr::random($jenis_akun),
        'remember_token' => Str::random(10),
    ];
});
