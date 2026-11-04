{{-- Одна форма для создания и редактирования --}}
<form method="POST" enctype="multipart/form-data"
      action="{{ $game->exists ? route('olympic-games.update', $game) : route('olympic-games.store') }}">
    @csrf
    @if ($game->exists)
        @method('PUT')
    @endif

    <div class="row g-3">
        @foreach ([
            'city'            => ['Город', 'text'],
            'year'            => ['Год', 'number'],
            'full_title'      => ['Полное название', 'text'],
            'card_type'       => ['Тип (надпись на карточке)', 'text'],
            'start_date'      => ['Дата начала', 'date'],
            'end_date'        => ['Дата окончания', 'date'],
            'stadium'         => ['Стадион', 'text'],
            'countries_count' => ['Количество стран', 'number'],
            'athletes_count'  => ['Количество атлетов', 'number'],
            'sports'          => ['Виды спорта (например: 28 (301 комплект))', 'text'],
            'medal_winner'    => ['Победитель медального зачёта', 'text'],
        ] as $name => [$label, $type])
            @php
                $value = old($name, $game->$name);
                if ($value instanceof \Carbon\CarbonInterface) {
                    $value = $value->format('Y-m-d');
                }
            @endphp
            <div class="col-md-6">
                <label for="{{ $name }}" class="form-label">{{ $label }}</label>
                <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" value="{{ $value }}" required
                       class="form-control @error($name) is-invalid @enderror">
                @error($name)
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        @endforeach

        <div class="col-12">
            <label for="card_text" class="form-label">Краткое описание (на карточке)</label>
            <input type="text" id="card_text" name="card_text" required maxlength="255"
                   value="{{ old('card_text', $game->card_text) }}"
                   class="form-control @error('card_text') is-invalid @enderror">
            @error('card_text')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="header_theme" class="form-label">Цветовая тема</label>
            <select id="header_theme" name="header_theme" required
                    class="form-select @error('header_theme') is-invalid @enderror">
                <option value="">— выберите —</option>
                @foreach (['athens', 'beijing', 'london', 'rio', 'tokyo'] as $theme)
                    <option value="{{ $theme }}" @selected(old('header_theme', $game->header_theme) === $theme)>{{ $theme }}</option>
                @endforeach
            </select>
            @error('header_theme')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="image" class="form-label">Изображение (jpg, png, webp до 4 МБ)</label>
            <input type="file" id="image" name="image" accept="image/*"
                   class="form-control @error('image') is-invalid @enderror">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12">
            <label for="facts" class="form-label">Интересные факты (по одному на строку)</label>
            <textarea id="facts" name="facts" rows="4"
                      class="form-control">{{ old('facts', implode("\n", $game->facts ?? [])) }}</textarea>
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{ route('olympic-games.index') }}" class="btn btn-outline-secondary">Отмена</a>
    </div>
</form>
