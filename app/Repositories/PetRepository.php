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

    protected function getSettingByName($name)
    {
        return $this->settings->firstWhere('name', $name);
    }

    public function decrease(string $attribute, array $ids) : int
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

    public function increase(Pet $pet, $attributeName)
    {
        if ($this->canIncrease($pet, $attributeName)) {
            $pet->update([
                $attributeName => data_get($pet, $attributeName) + 1,
                "{$attributeName}_at" => now()
            ]);
        }
    }

    public function canIncrease(Pet $pet, $attributeName)
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

    public function lowerFood()
    {
        $setting = $this->getSettingByName('food');
        $lowerTime = now()->subMinutes($setting->decrease_interval);

        $query = Pet::isAlive()
            ->where('food', '>=', $setting->critical_value)
            ->whereTime('lower_food_at', '<=', $lowerTime);

        $petIds = $this->getPetIds($query);

        $this->decrease('food', $petIds);
    }

    public function dieLowerFood()
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

    public function lowerSleep()
    {
        $setting = $this->getSettingByName('sleep');
        $lowerTime = now()->subMinutes($setting->decrease_interval);
        $query = Pet::isAlive()->whereTime('lower_sleep_at', '<=', $lowerTime);

        $petIds = $this->getPetIds($query);

        $this->decrease('sleep', $petIds);
    }

    public function lowerCare($lowerTime, $anotherLowerTime)
    {
        $setting = $this->getSettingByName('sleep');
        $lowerTime = now()->subMinutes($setting->decrease_interval);
        $criticalTime = now()->subMinutes($setting->decrease_interval);

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

    protected function getPetIds($query) : array
    {
        return $query->get()
            ->pluck('id')
            ->toArray();
    }
}
