<?php

namespace App\Http\Controllers;

use App\Events\UpdatePet;
use App\Models\Pet;
use App\Http\Requests\Pet\Create as CreateRequest;
use App\Http\Requests\Pet\Update as UpdateRequest;
use App\Repositories\PetRepository;

class PetsController extends Controller
{
    protected $pets;

    public function __construct(PetRepository $pets)
    {
        $this->pets = $pets;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return auth()->user()->pets;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $date = now();
        $data = $request->validated() + [
            'food_at' => $date,
            'sleep_at' => $date,
            'care_at' => $date,
            'fun_at' => $date,
            'lower_food_at' => $date,
            'lower_sleep_at' => $date,
            'lower_care_at' => $date,
            'lower_fun_at' => $date,
        ];

        $pet = auth()->user()->pets()->create($data);
        event(new UpdatePet([$pet->id]));

        return $pet;
    }

    /**
     * @param Pet $pet
     * @return Pet
     */
    public function show(Pet $pet)
    {
        return $pet;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Pet $pet)
    {
        $this->pets->increase($pet, $request->get('attribute'));
        $pet->refresh();

        return $pet;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pet $pet)
    {
        $pet->delete();
        event(new UpdatePet([$pet->id]));
        return $pet;
    }
}
