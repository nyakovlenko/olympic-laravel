<?php

namespace App\Http\Controllers;

use App\Models\OlympicGame;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class OlympicGameController extends Controller
{
    public function index()
    {
        return view('olympic-games.index', [
            'games' => OlympicGame::orderBy('year')->get(),
        ]);
    }

    public function create()
    {
        return view('olympic-games.create', ['game' => new OlympicGame]);
    }

    public function store(Request $request)
    {
        $game = OlympicGame::create($this->validated($request));

        return redirect()->route('olympic-games.show', $game)
            ->with('success', 'Олимпиада добавлена');
    }

    public function show(OlympicGame $olympicGame)
    {
        return view('olympic-games.show', ['game' => $olympicGame]);
    }

    public function edit(OlympicGame $olympicGame)
    {
        return view('olympic-games.edit', ['game' => $olympicGame]);
    }

    public function update(Request $request, OlympicGame $olympicGame)
    {
        $data = $this->validated($request);

        // загрузили новую картинку — удаляем старый файл
        if (isset($data['image_path']) && $olympicGame->image_path) {
            Storage::disk('public')->delete($olympicGame->image_path);
        }

        $olympicGame->update($data);

        return redirect()->route('olympic-games.show', $olympicGame)
            ->with('success', 'Изменения сохранены');
    }

    public function destroy(OlympicGame $olympicGame)
    {
        $olympicGame->delete(); // Soft Delete: запись остаётся в БД (deleted_at)

        return redirect()->route('olympic-games.index')
            ->with('success', 'Олимпиада удалена');
    }

    // ---------------- вспомогательные методы ----------------

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'city'            => ['required', 'string', 'max:100'],
            'year'            => ['required', 'integer', 'between:1896,2100'],
            'card_type'       => ['required', 'string', 'max:100'],
            'card_text'       => ['required', 'string', 'max:255'],
            'full_title'      => ['required', 'string', 'max:150'],
            'start_date'      => ['required', 'date'],
            'end_date'        => ['required', 'date', 'after_or_equal:start_date'],
            'stadium'         => ['required', 'string', 'max:150'],
            'countries_count' => ['required', 'integer', 'min:1'],
            'athletes_count'  => ['required', 'integer', 'min:1'],
            'sports'          => ['required', 'string', 'max:100'],
            'medal_winner'    => ['required', 'string', 'max:100'],
            'header_theme'    => ['required', 'in:athens,beijing,london,rio,tokyo'],
            'facts'           => ['nullable', 'string'],
            'image'           => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        // один факт = одна строка textarea
        $data['facts'] = array_values(array_filter(
            array_map('trim', explode("\n", $data['facts'] ?? ''))
        ));

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->storeImage($request->file('image'));
        }
        unset($data['image']);

        return $data;
    }

    // Меняем размер под верстку (карточка 300x250 → с запасом 600x500)
    private function storeImage(UploadedFile $file): string
    {
        $path = 'olympic-games/' . Str::uuid() . '.jpg';
        $image = Image::read($file)->cover(600, 500);
        Storage::disk('public')->put($path, (string) $image->toJpeg(85));

        return $path;
    }
}
