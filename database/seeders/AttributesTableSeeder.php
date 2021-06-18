<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = collect([
            [
                'name' => Attribute::FOOD,
                'increase_interval' => 5,
                'decrease_interval' => 10,
                'critical_value' => 5,
                'critical_interval' => 60
            ],
            [
                'name' => Attribute::SLEEP,
                'increase_interval' => 10,
                'decrease_interval' => 20,
                'critical_value' => 5,
                'critical_interval' => 0
            ],
            [
                'name' => Attribute::CARE,
                'increase_interval' => 5,
                'decrease_interval' => 15,
                'critical_value' => 0,
                'critical_interval' => 0
            ]
        ]);

        foreach ($data as $item) {
            Attribute::firstOrCreate([
                'name' => $item['name']
            ], $item);
        }
    }
}
