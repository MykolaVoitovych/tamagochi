<?php


namespace App\Repositories;


use App\Models\Pet;

class PetRepository
{
    public function updateFood($lowerTime, $diedTime)
    {
        $result = Pet::isAlive()
            ->where(function ($query) use ($lowerTime) {
                $query->where('sleep', '>=', 5)
                    ->whereTime('lower_food_at', '<=', $lowerTime)
                    ->update([
                        'lower_food_at' => now(),
                        'food' => \DB::raw('food - 1')
                    ]);
            })
            ->orWhere(function ($query) use ($diedTime) {
                $query->where('sleep', '<', 5)
                    ->whereTime('lower_food_at', '<=', $diedTime)
                    ->update([
                        'is_died' => true,
                        'food' => 0
                    ]);
            });

        if ($result) {
            //TODO new Event update models
        }
    }

    public function updateSleep($lowerTime, $anotherLowerTime)
    {
        $result = Pet::isAlive()
            ->where(function ($query) use ($lowerTime) {
                $query->where('sleep', '>=', 5)
                    ->whereTime('lower_sleep_at', '<=', $lowerTime);
            })
            ->orWhere(function ($query) use ($anotherLowerTime) {
                $query->where('sleep', '<', 5)
                    ->whereTime('lower_sleep_at', '<=', $anotherLowerTime);
            })
            ->update([
                'lower_sleep_at' => now(),
                'sleep' => \DB::raw('sleep - 1')
            ]); //15

        if ($result) {
            //TODO new Event update models
        }
    }

    public function updateCare($lowerTime)
    {
        $result = Pet::isAlive()
            ->whereTime('lower_care_at', '<=', $lowerTime)
            ->update([
                'lower_care_at' => now(),
                'care' => \DB::raw('care - 1')
            ]); //15

        if ($result) {
            //TODO new Event update models
        }
    }
}
