<?php

namespace Database\Seeders;

use App\Models\Mesaj;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MesajSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mesaj::insert([
            [
                'mesaj_kanallari_id' => 1,
                'kullanicilar_id' => 1,
                'mesaj' => 'Merhaba, nasılsınız?',
            ],
            [
                'mesaj_kanallari_id' => 1,
                'kullanicilar_id' => 2,
                'mesaj' => 'Merhaba, iyiyim. Teşekkür ederim.',
            ],
            [
                'mesaj_kanallari_id' => 1,
                'kullanicilar_id' => 1,
                'mesaj' => 'Sizden bir ricam olacak.',
            ],
            [
                'mesaj_kanallari_id' => 1,
                'kullanicilar_id' => 1,
                'mesaj' => 'Yardımcı olabilir misiniz?',
            ],
            [
                'mesaj_kanallari_id' => 1,
                'kullanicilar_id' => 2,
                'mesaj' => 'Tabii ki, ne istediğinizi söylerseniz yardımcı olmaya çalışırım.',
            ],
        ]);
    }
}
