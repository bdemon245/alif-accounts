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
            'হেলেন ট্রেড'=>[
                'name' => 'BHL',
                'address' => 'জগদীশমোড়, হবীগঞ্জ'
            ],
            'প্রাণ RFL'=>[
                'name' => null,
                'address' => 'অলিপুর, হবীগঞ্জ'
            ],
            'প্রাণ বেভারেজ লিঃ'=>[
                'name' => null,
                'address' => 'গোড়াশাল'
            ],
            'তৌহিদী লাইন্স'=>[
                'name' => '',
                'address' => 'KEPZ'
            ],
            'জয়নাল কার্গো'=>[
                'name' => '',
                'address' => ''
            ],
            'করিম ক্যারিয়ার'=>[
                'name' => '',
                'address' => ''
            ],
            'চারু সিরামিক্স লিঃ'=>[
                'name' => null,
                'address' => 'হবীগঞ্জ'
            ],
            'গ্রেট ওয়াল'=>[
                'name' => 'গ্রেট ওয়াল সিরামিক্স লিঃ',
                'address' => 'মাওনা'
            ],
        ];
        foreach ($parties as $key => $party) {
            Party::create(['name' => $party]);
        }
    }
}
