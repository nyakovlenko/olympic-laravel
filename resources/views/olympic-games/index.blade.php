@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
    <div>
        <h1 class="page-title">Летние Олимпийские игры</h1>
        <p class="page-subtitle">Олимпиады из базы данных: от Афин-2004 до Токио-2020</p>
    </div>
    <a href="{{ route('olympic-games.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus me-2"></i>Добавить
    </a>
</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xxxl-4 g-4 justify-content-center justify-content-lg-start" id="cardsContainer">
    @forelse ($games as $game)
        <div class="col">
            <div class="card h-100 card-custom">
                <div class="position-relative">
                    <img src="{{ $game->image_url }}" class="card-img-top img-fluid" alt="{{ $game->city }} {{ $game->year }}">
                    <div class="card-overlay"><span class="card-type">{{ $game->card_type }}</span></div>
                </div>
                <div class="card-body d-flex flex-column">
                    <h2 class="card-title h5">{{ $game->year }}, {{ $game->city }}</h2>
                    <p class="card-text flex-grow-1">{{ $game->card_text }}</p>

                    <a href="{{ route('olympic-games.show', $game) }}" class="btn btn-dark btn-details w-100 mb-2">
                        <i class="fa-solid fa-circle-info me-2"></i>Подробнее
                    </a>
                    <button type="button" class="btn btn-outline-secondary w-100 btn-load mb-2" data-year="{{ $game->year }}">
                        <i class="fa-solid fa-download me-2"></i>Загрузить
                    </button>
                    <div class="d-flex gap-2">
                        <a href="{{ route('olympic-games.edit', $game) }}" class="btn btn-outline-primary flex-fill">Изменить</a>
                        <form action="{{ route('olympic-games.destroy', $game) }}" method="POST" class="flex-fill"
                              onsubmit="return confirm('Удалить {{ $game->city }} {{ $game->year }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">Удалить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">Пока нет ни одной Олимпиады.</p>
    @endforelse
</div>
@endsection
