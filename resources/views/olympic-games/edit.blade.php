@extends('layouts.app')

@section('title', 'Редактирование')

@section('content')
    <h1 class="page-title mb-4">Редактирование: {{ $game->city }} {{ $game->year }}</h1>
    @include('olympic-games._form')
@endsection
