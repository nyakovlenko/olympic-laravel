<?php

namespace Database\Seeders;

use App\Models\OlympicGame;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class OlympicGameSeeder extends Seeder
{
    public function run(): void
    {
        $games = [
            [
                'year' => 2004,
                'city' => 'Афины',
                'full_title' => 'Афины 2004 — XXVIII Олимпийские игры',
                'card_type' => 'Летние Олимпийские игры',
                'card_text' => 'XXVIII летние Олимпийские игры.',
                'image' => 'https://avatars.mds.yandex.net/i?id=f207b3240413de337cb5ece87e61981d_l-5222505-images-thumbs&n=13',
                'header_theme' => 'athens',
                'start_date' => '2004-08-13',
                'end_date' => '2004-08-29',
                'stadium' => 'Афинский Олимпийский стадион',
                'countries_count' => 201,
                'athletes_count' => 10625,
                'sports' => '28 (301 комплект)',
                'medal_winner' => 'США',
                'facts' => [
                    'Олимпийский огонь впервые обошёл все континенты, побывав в Африке и Южной Америке.',
                    'Впервые в программу Олимпиады вошла женская вольная борьба.',
                ],
            ],
            [
                'year' => 2008,
                'city' => 'Пекин',
                'full_title' => 'Пекин 2008 — XXIX Олимпийские игры',
                'card_type' => 'Летние Олимпийские игры',
                'card_text' => 'XXIX летние Олимпийские игры.',
                'image' => 'https://avatars.mds.yandex.net/i?id=8264115a875bb96fcb1ab6db6d619e9d_l-9214146-images-thumbs&n=13',
                'header_theme' => 'beijing',
                'start_date' => '2008-08-08',
                'end_date' => '2008-08-24',
                'stadium' => '«Птичье гнездо»',
                'countries_count' => 204,
                'athletes_count' => 10942,
                'sports' => '28 (302 комплекта)',
                'medal_winner' => 'Китай',
                'facts' => [
                    'Церемония открытия стала самой массовой в истории — участвовало 15 000 человек.',
                    'Майкл Фелпс установил рекорд — 8 золотых медалей на одних Играх.',
                ],
            ],
            [
                'year' => 2012,
                'city' => 'Лондон',
                'full_title' => 'Лондон 2012 — XXX Олимпийские игры',
                'card_type' => 'Летние Олимпийские игры',
                'card_text' => 'XXX летние Олимпийские игры.',
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/73/2012_Summer_Olympics_Opening_Ceremony_Fireworks_Tower_Bridge.jpg/960px-2012_Summer_Olympics_Opening_Ceremony_Fireworks_Tower_Bridge.jpg',
                'header_theme' => 'london',
                'start_date' => '2012-07-27',
                'end_date' => '2012-08-12',
                'stadium' => 'Олимпийский стадион «Стратфорд»',
                'countries_count' => 204,
                'athletes_count' => 10768,
                'sports' => '26 (302 комплекта)',
                'medal_winner' => 'США',
                'facts' => [
                    'Лондон стал первым городом, принимавшим Олимпиаду трижды (1908, 1948, 2012).',
                    'Усэйн Болт повторил свой тройной успех Пекина: 100м, 200м и эстафета 4×100м.',
                ],
            ],
            [
                'year' => 2016,
                'city' => 'Рио-де-Жанейро',
                'full_title' => 'Рио-де-Жанейро 2016 — XXXI Олимпийские игры',
                'card_type' => 'Летние Олимпийские игры',
                'card_text' => 'XXXI летние Олимпийские игры.',
                'image' => 'https://olymps.ru/wp-content/uploads/2025/10/rio-2016-5.webp',
                'header_theme' => 'rio',
                'start_date' => '2016-08-05',
                'end_date' => '2016-08-21',
                'stadium' => 'Стадион «Маракана»',
                'countries_count' => 207,
                'athletes_count' => 11238,
                'sports' => '28 (306 комплектов)',
                'medal_winner' => 'США',
                'facts' => [
                    'Первые Олимпийские игры в Южной Америке в истории.',
                    'Майкл Фелпс завершил карьеру с 23 золотыми олимпийскими медалями — абсолютный рекорд.',
                ],
            ],
            [
                'year' => 2020,
                'city' => 'Токио',
                'full_title' => 'Токио 2020 — XXXII Олимпийские игры',
                'card_type' => 'Летние Олимпийские игры',
                'card_text' => 'XXXII летние Олимпийские игры.',
                'image' => 'https://images.news.ru/photo/3176e428-f842-11eb-8101-96000091f725.jpg',
                'header_theme' => 'tokyo',
                'start_date' => '2021-07-23',
                'end_date' => '2021-08-08',
                'stadium' => 'Национальный стадион Токио',
                'countries_count' => 206,
                'athletes_count' => 11656,
                'sports' => '33 (339 комплектов)',
                'medal_winner' => 'США',
                'facts' => [
                    'Первые Игры, прошедшие без зрителей из-за пандемии COVID-19. Перенесены на год.',
                    'Впервые в программу вошли скейтбординг, серфинг, спортивное скалолазание и карате.',
                ],
            ],
        ];

        foreach ($games as $game) {
            $url = $game['image'];
            unset($game['image']);

            $game['image_path'] = $this->downloadImage($url);
            OlympicGame::create($game);
        }
    }

    // Скачиваем картинку, меняем размер под верстку и сохраняем в storage/app/public
    private function downloadImage(string $url): ?string
    {
        try {
            $response = Http::withHeaders(['User-Agent' => 'Mozilla/5.0 (Macintosh) LaravelLab/1.0'])
                ->timeout(30)
                ->get($url);

            if (! $response->successful()) {
                $this->command->warn("Не удалось скачать картинку ($url): HTTP {$response->status()}");
                return null;
            }

            $path = 'olympic-games/' . Str::uuid() . '.jpg';
            $image = Image::read($response->body())->cover(600, 500);
            Storage::disk('public')->put($path, (string) $image->toJpeg(85));

            return $path;
        } catch (\Throwable $e) {
            $this->command->warn("Ошибка обработки картинки ($url): {$e->getMessage()}");
            return null;
        }
    }
}
