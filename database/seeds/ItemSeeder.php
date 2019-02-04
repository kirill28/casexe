<?php

use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            'item 1' => 1,
            'item 2' => 2,
            'item 3' => 3,
            'item 4' => 4,
            'item 5' => 5,
        ];

        foreach ($items as $name => $value) {
            \App\Models\Item::create([
                'name' => $name,
                'available_count' => $value,
            ]);
        }
    }
}
