@extends('layouts.app')

@section('title', $game->full_title)

@section('content')
@php $dark = $game->header_theme === 'beijing'; @endphp

<div class="modal-content glass-effect mx-auto" style="max-width: 900px">
    <div class="modal-header modal-header-{{ $game->header_theme }}">
        <h1 class="modal-title h5 {{ $dark ? 'text-dark' : 'text-white' }}">{{ $game->full_title }}</h1>
    </div>

    <div class="modal-body">
        <div class="row g-4">
            <div class="col-md-5">
                <img src="{{ $game->image_url }}" class="img-fluid rounded-3 shadow-sm modal-img" alt="{{ $game->city }} {{ $game->year }}">
            </div>
            <div class="col-md-7">
                <h6 class="text-muted mb-3 pb-2 border-bottom">Статистика</h6>
                <div class="stats-list">
                    @foreach ([
                        ['fa-regular fa-calendar', 'Даты', $game->dates_label],
                        ['fa-solid fa-landmark', 'Стадион', $game->stadium],
                        ['fa-solid fa-flag', 'Стран', $game->countries_count],
                        ['fa-solid fa-person-running', 'Атлетов', number_format($game->athletes_count, 0, '', ' ')],
                        ['fa-solid fa-medal', 'Видов спорта', $game->sports],
                    ] as [$icon, $label, $value])
                        <div class="stat-item d-flex justify-content-between py-2 {{ $loop->last ? '' : 'border-bottom' }}">
                            <span class="text-muted"><i class="{{ $icon }} fa-fw me-2"></i>{{ $label }}</span>
                            <span class="text-end">{{ $value }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="alert alert-light mt-4 border-0 glass-bg d-flex justify-content-between flex-wrap gap-2">
            <span class="text-muted">Победитель медального зачёта:</span>
            <strong>{{ $game->medal_winner }}</strong>
        </div>

        @if ($game->facts)
            <h6 class="mt-4 mb-3 text-muted">Интересные факты</h6>
            <div class="row g-3">
                @foreach ($game->facts as $fact)
                    <div class="col-md-6">
                        <div class="fact-card p-3 rounded-3 glass-bg border-0">
                            <p class="mb-0 small">{{ $fact }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="modal-footer border-0">
        <a href="{{ route('olympic-games.index') }}" class="btn btn-secondary me-auto">← К списку</a>
        <a href="{{ route('olympic-games.edit', $game) }}" class="btn btn-outline-primary">Изменить</a>
    </div>
</div>
@endsection
