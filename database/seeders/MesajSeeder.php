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
                'kullanicilar_id'    => 1,
                'mesaj'              => 'Merhaba, nasılsınız?',
                'isletmeler_id'      => null,
                'unvanlar_id'        => null
            ],
            [
                'mesaj_kanallari_id' => 1,
                'kullanicilar_id'    => 2,
                'mesaj'              => 'Merhaba, iyiyim. Teşekkür ederim.',
                'isletmeler_id'      => 143,
                'unvanlar_id'        => 1
            ],
            [
                'mesaj_kanallari_id' => 1,
                'kullanicilar_id'    => 1,
                'mesaj'              => 'Sizden bir ricam olacak.',
                'isletmeler_id'      => null,
                'unvanlar_id'        => null
            ],
            [
                'mesaj_kanallari_id' => 1,
                'kullanicilar_id'    => 1,
                'mesaj'              => 'Yardımcı olabilir misiniz?',
                'isletmeler_id'      => null,
                'unvanlar_id'        => null
            ],
            [
                'mesaj_kanallari_id' => 1,
                'kullanicilar_id'    => 2,
                'mesaj'              => 'Tabii ki, ne istediğinizi söylerseniz yardımcı olmaya çalışırım.',
                'isletmeler_id'      => 143,
                'unvanlar_id'        => 1
            ],
        ]);
    }
}
