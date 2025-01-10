<?php

namespace Database\Seeders;

use App\Models\Isletme;
use App\Models\IsletmeBirim;
use Illuminate\Database\Seeder;

class IsletmeBirimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $universiteBirimleri = [
            ['birim_ad' => "Mühendislik Fakültesi", 'birim_tip_id' => 1],
            ['birim_ad' => "İktisadi ve İdari Bilimler Fakültesi", 'birim_tip_id' => 1],
            ['birim_ad' => "Hukuk Fakültesi", 'birim_tip_id' => 1],
            ['birim_ad' => "Tıp Fakültesi", 'birim_tip_id' => 1],
            ['birim_ad' => "Eğitim Fakültesi", 'birim_tip_id' => 1],
            ['birim_ad' => "Fen Edebiyat Fakültesi", 'birim_tip_id' => 1],
            ['birim_ad' => "Güzel Sanatlar Fakültesi", 'birim_tip_id' => 1],
            ['birim_ad' => "İletişim Fakültesi", 'birim_tip_id' => 1],
            ['birim_ad' => "Diş Hekimliği Fakültesi", 'birim_tip_id' => 1],
            ['birim_ad' => "Eczacılık Fakültesi", 'birim_tip_id' => 1],
            ['birim_ad' => "Sağlık Bilimleri Fakültesi", 'birim_tip_id' => 1],
            ['birim_ad' => "Ziraat Fakültesi", 'birim_tip_id' => 1],
            ['birim_ad' => "Veteriner Fakültesi", 'birim_tip_id' => 1],
            ['birim_ad' => "Spor Bilimleri Fakültesi", 'birim_tip_id' => 1],
            ['birim_ad' => "Mimarlık Fakültesi", 'birim_tip_id' => 1],
            ['birim_ad' => "Denizcilik Fakültesi", 'birim_tip_id' => 1],
            ['birim_ad' => "Havacılık ve Uzay Bilimleri Fakültesi", 'birim_tip_id' => 1],
            ['birim_ad' => "Fen Bilimleri Enstitüsü", 'birim_tip_id' => 2],
            ['birim_ad' => "Sosyal Bilimler Enstitüsü", 'birim_tip_id' => 2],
            ['birim_ad' => "Sağlık Bilimleri Enstitüsü", 'birim_tip_id' => 2],
            ['birim_ad' => "Eğitim Bilimleri Enstitüsü", 'birim_tip_id' => 2],
            ['birim_ad' => "Turizm Yüksekokulu", 'birim_tip_id' => 3],
            ['birim_ad' => "Yabancı Diller Yüksekokulu", 'birim_tip_id' => 3],
            ['birim_ad' => "Beden Eğitimi ve Spor Yüksekokulu", 'birim_tip_id' => 3],
            ['birim_ad' => "Uygulamalı Bilimler Yüksekokulu", 'birim_tip_id' => 3],
            ['birim_ad' => "Denizcilik Yüksekokulu", 'birim_tip_id' => 3],
            ['birim_ad' => "Hemşirelik Yüksekokulu", 'birim_tip_id' => 3],
            ['birim_ad' => "Havacılık Yüksekokulu", 'birim_tip_id' => 3],
            ['birim_ad' => "Sanat ve Tasarım Yüksekokulu", 'birim_tip_id' => 3],
            ['birim_ad' => "Teknik Bilimler Meslek Yüksekokulu", 'birim_tip_id' => 8],
            ['birim_ad' => "Sağlık Hizmetleri Meslek Yüksekokulu", 'birim_tip_id' => 8],
            ['birim_ad' => "Adalet Meslek Yüksekokulu", 'birim_tip_id' => 8],
            ['birim_ad' => "Sosyal Bilimler Meslek Yüksekokulu", 'birim_tip_id' => 8],
            ['birim_ad' => "Otelcilik ve Turizm Meslek Yüksekokulu", 'birim_tip_id' => 8],
            ['birim_ad' => "Uzaktan Eğitim Merkezi", 'birim_tip_id' => 5],
            ['birim_ad' => "Kariyer Planlama Merkezi", 'birim_tip_id' => 5],
            ['birim_ad' => "Sürekli Eğitim Merkezi", 'birim_tip_id' => 5],
            ['birim_ad' => "Teknoloji Transfer Ofisi", 'birim_tip_id' => 5],
            ['birim_ad' => "Dil Eğitim Merkezi", 'birim_tip_id' => 5],
            ['birim_ad' => "Rektörlük", 'birim_tip_id' => 9],
            ['birim_ad' => "Kütüphane ve Dökümantasyon Daire Başkanlığı", 'birim_tip_id' => 4],
            ['birim_ad' => "Öğrenci İşleri Daire Başkanlığı", 'birim_tip_id' => 4],
            ['birim_ad' => "Sağlık, Kültür ve Spor Daire Başkanlığı", 'birim_tip_id' => 4],
            ['birim_ad' => "Bilgi İşlem Daire Başkanlığı", 'birim_tip_id' => 4],
            ['birim_ad' => "Personel Daire Başkanlığı", 'birim_tip_id' => 4],
            ['birim_ad' => "İdari ve Mali İşler Daire Başkanlığı", 'birim_tip_id' => 4],
            ['birim_ad' => "Laboratuvarlar", 'birim_tip_id' => 7],
            ['birim_ad' => "Teknopark", 'birim_tip_id' => 7],
            ['birim_ad' => "Genel Sekreterlik", 'birim_tip_id' => 9],
            ['birim_ad' => "Bilgi Edinme Birimi", 'birim_tip_id' => 7],
            ['birim_ad' => "Strateji Geliştirme Daire Başkanlığı", 'birim_tip_id' => 4],
            ['birim_ad' => "Yapı İşleri ve Teknik Daire Başkanlığı", 'birim_tip_id' => 4],
            ['birim_ad' => "Hukuk Müşavirliği", 'birim_tip_id' => 9],
            ['birim_ad' => "Yazı İşleri Müdürlüğü", 'birim_tip_id' => 6],
            ['birim_ad' => "Döner Sermaye İşl.M.", 'birim_tip_id' => 6],
            ['birim_ad' => "Basın ve Halkla İlişkiler Birimi", 'birim_tip_id' => 7],
            ['birim_ad' => "Kurum Arşiv Birimi", 'birim_tip_id' => 7],
            ['birim_ad' => "İktisadi İşletme Müdürlüğü", 'birim_tip_id' => 6],
            ['birim_ad' => "Özel Kalem Müdürlüğü", 'birim_tip_id' => 6],
            ['birim_ad' => "Kurum Genel", 'birim_tip_id' => 9, 'aktiflik' => 0],
        ];

        $isletmeler = Isletme::whereIn('isletmeler_id', [143, 144])->get();

        foreach ($isletmeler as $isletme) {
            foreach ($universiteBirimleri as $birim) {
                IsletmeBirim::create([
                    'isletmeler_id'    => $isletme['isletmeler_id'],
                    'birim_tipleri_id' => $birim['birim_tip_id'],
                    'baslik'           => $birim['birim_ad'],
                ]);
            }
        }
    }
}
