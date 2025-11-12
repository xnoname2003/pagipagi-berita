<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use App\Models\Komentar;
use App\Models\Wartawan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $wartawans = Wartawan::factory(2)->create();

        $jumlah_berita = 10; 

        $wartawans = Wartawan::all();

        $all_berita = collect();

        for ($i = 0; $i < $jumlah_berita; $i++) {
            $wartawan = $wartawans->random();
            $berita = News::factory()->create([
                'wartawan_id' => $wartawan->id,
            ]);
            $all_berita->push($berita);
        }

        foreach ($all_berita as $berita) {
            Komentar::factory(5)->create([
                'news_id' => $berita->id,
            ]);
        }

    }
}
