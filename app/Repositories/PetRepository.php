<?php


namespace App\Repositories;


use App\Events\UpdatePet;
use App\Models\Pet;

class PetRepository
{
    public function lowerAttribute(string $attribute, array $ids) : int
    {
        return Pet::whereIn('id', $ids)
            ->update([
                "lower_{$attribute}_at" => now(),
                $attribute => \DB::raw($attribute . ' - 1')
            ]);
    }

    public function lowerFood($lowerTime)
    {
        $updatedIds = Pet::isAlive()
            ->where('food', '>=', 5)
            ->whereTime('lower_food_at', '<=', $lowerTime)
            ->get()
            ->pluck('id')
            ->toArray();

        if (count($updatedIds)) {
            $this->lowerAttribute('food', $updatedIds);
            event(new UpdatePet($updatedIds));
        }
    }

    public function dieLowerFood($diedTime)
    {
        $diedIds = Pet::isAlive()
            ->where('food', '<', 5)
            ->whereTime('food_at', '<=', $diedTime)
            ->get()
            ->pluck('id')
            ->toArray();

        if (count($diedIds)) {
            Pet::whereIn('id', $diedIds)
                ->update([
                    'is_died' => true,
                    'food' => 0
                ]);
            event(new UpdatePet($diedIds));
        }
    }

    public function lowerSleep($lowerTime)
    {
        $petIds = Pet::isAlive()
            ->whereTime('lower_sleep_at', '<=', $lowerTime)
            ->get()
            ->pluck('id')
            ->toArray();

        if (count($petIds)) {
            $this->lowerAttribute('sleep', $petIds);
            event(new UpdatePet($petIds));
        }
    }

    public function lowerCare($lowerTime, $anotherLowerTime)
    {
        $petIds = Pet::isAlive()
            ->where(function ($query) use ($lowerTime) {
                $query->where('sleep', '>=', 5)
                    ->whereTime('lower_care_at', '<=', $lowerTime);
            })
            ->orWhere(function ($query) use ($anotherLowerTime) {
                $query->where('sleep', '<', 5)
                    ->whereTime('lower_care_at', '<=', $anotherLowerTime);
            })
            ->get()
            ->pluck('id')
            ->toArray();

        if (count($petIds)) {
            $this->lowerAttribute('care', $petIds);
            event(new UpdatePet($petIds));
        }
    }
}
