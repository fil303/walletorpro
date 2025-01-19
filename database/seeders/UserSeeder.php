<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        if(!$admin = User::where("role", UserRole::SUPERADMIN->value)->first()){
            $admin = [
                "uid"        => uniqid("UID"),
                "first_name" => "Mr",
                "last_name"  => "Admin",
                "name"       => "Mr Admin",
                "username"   => "mr-admin",
                "email"      => "admin@email.com",
                "role"       => UserRole::SUPERADMIN->value,
                "country"    => 'bd',
                "language"   => 'en',
                "status"     => "active",
                "password"   => Hash::make(123456),
            ]; User::create($admin);
            $user = [
                "uid"        => uniqid("UID"),
                "first_name" => "Mr",
                "last_name"  => "User",
                "name"       => "Mr User",
                "username"   => "mr-user",
                "email"      => "user@email.com",
                "role"       => UserRole::USER->value,
                "country"    => 'bd',
                "language"   => 'en',
                "status"     => "active",
                "password"   => Hash::make(123456),
            ]; User::create($user);
        }

        $faker = Faker::create();

        foreach(range(0, 0) as $d){
            $user = [
                "uid"        => uniqid("UID"),
                "first_name" => $faker->name,
                "last_name"  => $faker->name,
                "name"       => $faker->name,
                "username"   => $faker->unique()->username,
                "email"      => $faker->email(),
                "country"    => 'bd',
                "language"   => 'en',
                "status"     => (["active", "suspended", "deleted"])[rand(0,2)],
                "password"   => Hash::make(123456),
            ];

            User::create($user);
        }
    }
}
