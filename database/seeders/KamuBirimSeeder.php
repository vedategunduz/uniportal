<?php

namespace Database\Seeders;

use App\Models\Kamu;
use App\Models\KamuBirim;
use Illuminate\Database\Seeder;

class KamuBirimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $universiteBirimleri = [
            "Mühendislik Fakültesi",
            "İktisadi ve İdari Bilimler Fakültesi",
            "Hukuk Fakültesi",
            "Tıp Fakültesi",
            "Eğitim Fakültesi",
            "Fen Edebiyat Fakültesi",
            "Güzel Sanatlar Fakültesi",
            "İletişim Fakültesi",
            "Diş Hekimliği Fakültesi",
            "Eczacılık Fakültesi",
            "Sağlık Bilimleri Fakültesi",
            "Ziraat Fakültesi",
            "Veteriner Fakültesi",
            "Spor Bilimleri Fakültesi",
            "Mimarlık Fakültesi",
            "Denizcilik Fakültesi",
            "Havacılık ve Uzay Bilimleri Fakültesi",
            "Fen Bilimleri Enstitüsü",
            "Sosyal Bilimler Enstitüsü",
            "Sağlık Bilimleri Enstitüsü",
            "Eğitim Bilimleri Enstitüsü",
            "Turizm Yüksekokulu",
            "Yabancı Diller Yüksekokulu",
            "Beden Eğitimi ve Spor Yüksekokulu",
            "Uygulamalı Bilimler Yüksekokulu",
            "Denizcilik Yüksekokulu",
            "Hemşirelik Yüksekokulu",
            "Havacılık Yüksekokulu",
            "Sanat ve Tasarım Yüksekokulu",
            "Teknik Bilimler Meslek Yüksekokulu",
            "Sağlık Hizmetleri Meslek Yüksekokulu",
            "Adalet Meslek Yüksekokulu",
            "Sosyal Bilimler Meslek Yüksekokulu",
            "Otelcilik ve Turizm Meslek Yüksekokulu",
            "Uzaktan Eğitim Merkezi",
            "Kariyer Planlama Merkezi",
            "Sürekli Eğitim Merkezi",
            "Teknoloji Transfer Ofisi",
            "Dil Eğitim Merkezi",
            "Rektörlük",
            "Kütüphane ve Dökümantasyon Daire Başkanlığı",
            "Öğrenci İşleri Daire Başkanlığı",
            "Sağlık, Kültür ve Spor Daire Başkanlığı",
            "Bilgi İşlem Daire Başkanlığı",
            "Personel Daire Başkanlığı",
            "İdari ve Mali İşler Daire Başkanlığı",
            "Laboratuvarlar",
            "Teknopark",
            "Genel Sekreterlik",
            "Bilgi Edinme Birimi",
            "Strateji Geliştirme Daire Başkanlığı",
            "Yapı İşleri ve Teknik Daire Başkanlığı",
            "Hukuk Müşavirliği",
            "Yazı İşleri Müdürlüğü",
            "Döner Sermaye İşl.M.",
            "Basın ve Halkla İlişkiler Birimi",
            "Kurum Arşiv Birimi",
            "İktisadi İşletme Müdürlüğü",
            "Özel Kalem Müdürlüğü",
        ];

        $kamular = Kamu::where('kamular_id', 143)->get();

        foreach ($kamular as $kamu) {
            foreach($universiteBirimleri as $birim) {
                KamuBirim::create([
                    'kamular_id' => $kamu['kamular_id'],
                    'birim_ad' => $birim,
                ]);
            }
        }

    }
}
