<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Trailer;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = Company::factory(10)->create();
        $characters = [
            'CMTA 11',
            'CMTA 12',
            'CMSHA 11',
            'CMDA 81',
            'DMTA 80',
            'DMTA 20',
            'DMTA 11',
            'DMTA 84',
            'DMDA 80',
            'DMDA 84',
            'FPDA 11'
        ];
        function trailerNumber()
        {
            $characters = [
                'CMTA 11',
                'CMTA 12',
                'CMSHA 11',
                'CMDA 81',
                'DMTA 80',
                'DMTA 20',
                'DMTA 11',
                'DMTA 84',
                'DMDA 80',
                'DMDA 84',
                'FPDA 11'
            ];
            return fake()->randomElement($characters)
                . "-" . fake()->randomDigit()
                . fake()->randomDigit()
                . fake()->randomDigit()
                . fake()->randomDigit();
        }

        foreach ($companies as $key => $company) {
            foreach (range(1, 6) as $key => $value) {
                $trailer = Trailer::create([
                    'number' => trailerNumber()
                ]);
                $company->trailers()->attach($trailer->id);
            }
        }
    }
}
