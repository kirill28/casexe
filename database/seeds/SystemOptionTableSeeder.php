<?php

use App\Models\SystemOption;
use Illuminate\Database\Seeder;

class SystemOptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $options = [
            SystemOption::BONUS_POINTS_MIN_VALUE => 1,
            SystemOption::BONUS_POINTS_MAX_VALUE => 10,
            SystemOption::MONEY_TO_BONUS_POINTS_COEFFICIENT => 2.5,
            SystemOption::MONEY_MIN_VALUE => 1,
            SystemOption::MONEY_MAX_VALUE => 5,
            SystemOption::PRIVAT_BANK_MERCHANT_ID => 142375,
            SystemOption::PRIVAT_BANK_MERCHANT_PASSWORD => 'o7L3T18KG3615Ei7L5VeNQ1dK7zXa65F',
            SystemOption::PRIVAT_BANK_ENABLE_PAYMENTS => 0,
        ];

        foreach ($options as $name => $value) {
            SystemOption::create([
                'name' => $name,
                'value' => $value,
            ]);
        }
    }
}
