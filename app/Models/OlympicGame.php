<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class OlympicGame extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'city', 'year', 'card_type', 'card_text', 'full_title', 'image_path',
        'start_date', 'end_date', 'stadium', 'countries_count',
        'athletes_count', 'sports', 'medal_winner', 'facts', 'header_theme',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date'   => 'date',
            'facts'      => 'array',
        ];
    }

    // ---- мутаторы (запись в БД) ----

    protected function startDate(): Attribute
    {
        return Attribute::make(set: fn ($value) => Carbon::parse($value)->toDateString());
    }

    protected function endDate(): Attribute
    {
        return Attribute::make(set: fn ($value) => Carbon::parse($value)->toDateString());
    }

    protected function city(): Attribute
    {
        return Attribute::make(set: fn ($value) => trim($value));
    }

    // ---- аксессоры (чтение) ----

    protected function datesLabel(): Attribute
    {
        return Attribute::make(get: fn () =>
            $this->start_date->translatedFormat('j F') . ' – ' . $this->end_date->translatedFormat('j F Y')
        );
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(get: fn () => $this->image_path
            ? Storage::url($this->image_path)
            : 'https://placehold.co/600x500?text=No+image'
        );
    }
}
