<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('ja_JP'); // 日本語のデータを生成

        for ($i = 0; $i < 30; $i++) {
            Customer::create([
                'name' => $faker->company,
                'kana' => $faker->kanaName,
                'zip' => $faker->postcode,
                'address' => $faker->address,
                'tel' => $faker->phoneNumber,
                'memo' => $faker->sentence,
            ]);
        }
    }
}
