<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
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
                'name' => 'food',
                'increase_interval' => 5,
                'decrease_interval' => 10,
                'critical_value' => 5,
                'critical_interval' => 60
            ],
            [
                'name' => 'sleep',
                'increase_interval' => 10,
                'decrease_interval' => 20,
                'critical_value' => 5,
                'critical_interval' => 0
            ],
            [
                'name' => 'care',
                'increase_interval' => 5,
                'decrease_interval' => 15,
                'critical_value' => 0,
                'critical_interval' => 0
            ]
        ]);

        foreach ($data as $item) {
            Setting::firstOrCreate([
                'name' => $item['name']
            ], $item);
        }
    }
}
