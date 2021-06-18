<?php

namespace App\Console\Commands;

use App\Models\AttributePet;
use App\Models\Pet;
use App\Repositories\PetRepository;
use Illuminate\Console\Command;

class UpdateCharacteristics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-characteristics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lower pet characteristic';

    protected $pets;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(PetRepository $pets)
    {
        $this->pets = $pets;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $attributePets = AttributePet::whereHas('pet', function ($query) {
            $query->isAlive();
        })->get();

        $needDecreaseAttributePets = [];
        $needDieAttributePetIds = [];

        foreach ($attributePets as $attributePet) {
            if ($attributePet->canDecrease()) {
                array_push($needDecreaseAttributePets, $attributePet->id);
            } else if ($attributePet->canDie()) {
                array_push($needDieAttributePetIds, $attributePet->id);
            }
        }

        $this->pets->decrease($needDecreaseAttributePets);
        $this->pets->die($needDieAttributePetIds);
    }
}
