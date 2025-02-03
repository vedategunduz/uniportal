<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rol::insert(
            [
                // 1
                [
                    'baslik' => 'Admin'
                ],
                // 2
                [
                    'baslik' => 'Kurum yönetici'
                ],
                // 3
                [
                    'baslik' => 'Birim yönetici'
                ],
                // 4
                [
                    'baslik' => 'İzlem veri giriş'
                ],
                // 5
                [
                    'baslik' => 'SP veri giriş'
                ],
                // 6
                [
                    'baslik' => 'Basın'
                ],
                // 7
                [
                    'baslik' => 'Döküman oluşturma yetkilisi'
                ],
                // 8
                [
                    'baslik' => 'Döküman birim onay'
                ],
                // 9
                [
                    'baslik' => 'Döküman kurum onay'
                ],
                // 10
                [
                    'baslik' => 'İş takip birim yetkilisi'
                ],
                // 11
                [
                    'baslik' => 'İş takip personeli'
                ],
                // 12
                [
                    'baslik' => 'Raportör'
                ],
                // 13
                [
                    'baslik' => 'Etkinlik yetkilisi'
                ],
                // 14
                [
                    'baslik' => 'Sarf Talep yetkilisi'
                ],
                // 15
                [
                    'baslik' => 'Ortak alım yetkilisi'
                ],
                // 16
                [
                    'baslik' => 'Sponsor yetkilisi'
                ],
                // 17
                [
                    'baslik' => 'Toplantı yetkilisi'
                ],
                // 18
                [
                    'baslik' => 'Personel'
                ]
            ]
        );
    }
}
