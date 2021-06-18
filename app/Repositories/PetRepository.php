<?php


namespace App\Repositories;


use App\Events\UpdatePet;
use App\Models\AttributePet;
use App\Models\Attribute;
use App\Models\Pet;

class PetRepository
{
    protected $settings;

    public function __construct(Attribute $settings)
    {
        $this->settings = $settings;
    }

    public function decrease(array $attributePetIds): void
    {
        if (count($attributePetIds)) {
            AttributePet::whereIn('id', $attributePetIds)
                ->update([
                    'dt_decreased' => now(),
                    'value' => \DB::raw('value - 1')
                ]);

            $petIds = AttributePet::whereIn('id', $attributePetIds)
                ->select(['pet_id'])
                ->get()
                ->pluck('pet_id')
                ->toArray();

            event(new UpdatePet($petIds));
        }
    }

    public function increase(Pet $pet, string $attributeName): void
    {
        $attribute = $pet->getAttributeByName($attributeName);
        $attributePet = AttributePet::where('pet_id', $pet->id)
            ->where('attribute_id', $attribute->id)
            ->first();

        if ($attributePet && $attributePet->canIncrease()) {
            $attributePet->update([
                'value' => $attributePet->value + 1,
                'dt_increased' => now(),
            ]);
            event(new UpdatePet([$pet->id]));
        }
    }

    public function die(array $attributePetIds)
    {
        Pet::whereHas('attributes', function ($query) use ($attributePetIds) {
            $query->whereIn('attribute_pet.id', $attributePetIds);
        })->update([
            'is_died' => 1
        ]);

        $this->decrease($attributePetIds);
    }
}
