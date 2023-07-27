<?php

namespace Database\Seeders;

use App\Models\Party;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parties = [
            'হেলেন ট্রেড',
            'প্রাণ RFL',
            'প্রাণ বেভারেজ লিঃ',
            'তৌহিদী লাইন্স',
            'জয়নাল কার্গো',
            'করিম ক্যারিয়ার',
            'চারু সিরামিক্স',
            'গ্রেট ওয়াল '
        ];
        foreach ($parties as $key => $party) {
            Party::create(['name' => $party]);
        }
    }
}
