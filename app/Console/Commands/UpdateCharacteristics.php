<?php

namespace App\Console\Commands;

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
        $this->pets->lowerFood();
        $this->pets->dieLowerFood();
        $this->pets->lowerSleep();
        $this->pets->lowerCare();
    }
}
