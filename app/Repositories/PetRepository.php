<?php


namespace App\Repositories;


use App\Events\UpdatePet;
use App\Models\Pet;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Builder;

class PetRepository
{
    protected $settings;

    public function __construct(Setting $settings)
    {
        $this->settings = $settings;
    }

    protected function getSettingByName(string $name)
    {
        return $this->settings->firstWhere('name', $name);
    }

    public function decrease(string $attribute, array $ids): void
    {
        if (count($ids)) {
            Pet::whereIn('id', $ids)
                ->update([
                    "lower_{$attribute}_at" => now(),
                    $attribute => \DB::raw($attribute . ' - 1')
                ]);

            event(new UpdatePet($ids));
        }
    }

    public function increase(Pet $pet, string $attributeName): void
    {
        if ($this->canIncrease($pet, $attributeName)) {
            $pet->update([
                $attributeName => $pet->$attributeName + 1,
                "{$attributeName}_at" => now()
            ]);
            event(new UpdatePet([$pet->id]));
        }
    }

    public function canIncrease(Pet $pet, string $attributeName) : bool
    {
        $setting = $this->getSettingByName($attributeName);
        if ($setting) {
            $allowIncreaseTime = now()->subMinutes($setting->increase_interval);
            if (
                ($pet->$attributeName < $setting->max_value)
                && data_get($pet, "{$attributeName}_at")->lt($allowIncreaseTime)
            ) {
                return true;
            }
        }
        return false;
    }

    public function lowerFood(): void
    {
        $setting = $this->getSettingByName('food');
        $lowerTime = now()->subMinutes($setting->decrease_interval);

        $query = Pet::isAlive()
            ->where('food', '>=', $setting->critical_value)
            ->whereTime('lower_food_at', '<=', $lowerTime);

        $petIds = $this->getPetIds($query);

        $this->decrease('food', $petIds);
    }

    public function dieLowerFood(): void
    {
        $setting = $this->getSettingByName('food');
        $diedTime = now()->subMinutes($setting->critical_interval);

        $query = Pet::isAlive()
            ->where('food', '<', $setting->critical_value)
            ->whereTime('food_at', '<=', $diedTime);

        $diedIds = $this->getPetIds($query);

        if (count($diedIds)) {
            Pet::whereIn('id', $diedIds)
                ->update([
                    'is_died' => true,
                    'food' => 0
                ]);
            event(new UpdatePet($diedIds));
        }
    }

    public function lowerSleep(): void
    {
        $setting = $this->getSettingByName('sleep');
        $lowerTime = now()->subMinutes($setting->decrease_interval);
        $query = Pet::isAlive()->whereTime('lower_sleep_at', '<=', $lowerTime);

        $petIds = $this->getPetIds($query);

        $this->decrease('sleep', $petIds);
    }

    public function lowerCare(): void
    {
        $setting = $this->getSettingByName('care');
        $lowerTime = now()->subMinutes($setting->decrease_interval);
        $criticalTime = now()->subMinutes($setting->critical_interval);

        $query = Pet::isAlive()
            ->where(function ($query) use ($setting, $lowerTime) {
                $query->where('sleep', '>=', $setting->critical_interval)
                    ->whereTime('lower_care_at', '<=', $lowerTime);
            })
            ->orWhere(function ($query) use ($setting, $criticalTime) {
                $query->where('sleep', '<', $setting->critical_interval)
                    ->whereTime('lower_care_at', '<=', $criticalTime);
            });

        $petIds = $this->getPetIds($query);

        $this->decrease('care', $petIds);
    }

    protected function getPetIds(Builder $query) : array
    {
        return $query->get()
            ->pluck('id')
            ->toArray();
    }
}
