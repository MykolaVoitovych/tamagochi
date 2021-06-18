@extends('layouts.base')

@section('main')
    @routes
    <main
        id="app"
        data-user='{{ auth()->user() }}'
        data-pet-types='{{ \App\Models\Pet::types() }}'
        data-pets='{{ auth()->user()->pets }}'
        data-settings='{{ \App\Models\Attribute::all() }}'
    >
    </main>
@endsection
