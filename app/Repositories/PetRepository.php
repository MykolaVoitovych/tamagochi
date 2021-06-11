<?php


namespace App\Repositories;


use App\Events\UpdatePet;
use App\Models\Pet;

class PetRepository
{
    public function updateFood($lowerTime, $diedTime)
    {
        $result = Pet::isAlive()->where('food', '>=', 5)
            ->whereTime('lower_food_at', '<=', $lowerTime)
            ->update([
                'lower_food_at' => now(),
                'food' => \DB::raw('food - 1')
            ]);

        $diedResult = Pet::isAlive()
            ->where('food', '<', 5)
            ->whereTime('lower_food_at', '<=', $diedTime)
            ->update([
                'is_died' => true,
                'food' => 0
            ]);

        if ($result || $diedResult) {
            event(new UpdatePet());
        }
    }

    public function updateSleep($lowerTime)
    {
        $result = Pet::isAlive()
            ->whereTime('lower_sleep_at', '<=', $lowerTime)
            ->update([
                'lower_sleep_at' => now(),
                'sleep' => \DB::raw('sleep - 1')
            ]);

        if ($result) {
            event(new UpdatePet());
        }
    }

    public function updateCare($lowerTime, $anotherLowerTime)
    {
        $result = Pet::isAlive()
            ->where(function ($query) use ($lowerTime) {
                $query->where('sleep', '>=', 5)
                    ->whereTime('lower_care_at', '<=', $lowerTime);
            })
            ->orWhere(function ($query) use ($anotherLowerTime) {
                $query->where('sleep', '<', 5)
                    ->whereTime('lower_care_at', '<=', $anotherLowerTime);
            })
            ->update([
                'lower_care_at' => now(),
                'care' => \DB::raw('care - 1')
            ]);

        if ($result) {
            event(new UpdatePet());
        }
    }
}
