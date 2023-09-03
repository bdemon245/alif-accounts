<?php

namespace Database\Seeders;

use App\Models\Party;
use App\Models\Phone;
use App\Models\Factory;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PartySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parties = [
            'হেলেন ট্রেড' => [
                'name' => 'BHL',
                'address' => 'জগদীশমোড়, হবীগঞ্জ'
            ],
            'প্রাণ RFL' => [
                'name' => null,
                'address' => 'অলিপুর, হবীগঞ্জ'
            ],
            'প্রাণ বেভারেজ লিঃ' => [
                'name' => null,
                'address' => 'গোড়াশাল'
            ],
            'তৌহিদী লাইন্স' => [
                'name' => '',
                'address' => 'KEPZ'
            ],
            'জয়নাল কার্গো' => [
                'name' => '',
                'address' => 'জরিনা বাজার'
            ],
            'করিম ক্যারিয়ার' => [
                'name' => '',
                'address' => 'ডেমরা'
            ],
            'চারু সিরামিক্স লিঃ' => [
                'name' => null,
                'address' => 'হবীগঞ্জ'
            ],
            'গ্রেট ওয়াল' => [
                'name' => 'গ্রেট ওয়াল সিরামিক্স লিঃ',
                'address' => 'মাওনা'
            ],
        ];
        foreach ($parties as $key => $party) {
            $name = Arr::join($party, ', ');
            $item = Party::create(['name' => $key]);
            $factory = Factory::create([
                'party_id' => $item->id,
                'name' => str($name)->ltrim(','),
            ]);
            $phone = Phone::create([
                'number' => fake()->phoneNumber(),
                'phonable_type' => Factory::class,
                'phonable_id' => $factory->id
            ]);
            $phone = Phone::create([
                'number' => fake()->phoneNumber(),
                'phonable_type' => Factory::class,
                'phonable_id' => $factory->id
            ]);
        }
    }
}
