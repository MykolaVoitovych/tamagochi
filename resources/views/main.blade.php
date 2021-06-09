@extends('layouts.base')

@section('main')
    <main
        id="app"
        data-user='{{ auth()->user() }}'
    >
    </main>
@endsection
