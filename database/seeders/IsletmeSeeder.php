<?php

namespace Database\Seeders;

use App\Models\Isletme;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class IsletmeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $universiteler = [
            ['baslik' => 'Abant İzzet Baysal Üniversitesi',                   'il' => 14, 'mailUzanti' => 'ibu.edu.tr',           'kisaltma' => 'İBU'],
            ['baslik' => 'Abdullah Gül Üniversitesi',                          'il' => 38, 'mailUzanti' => 'agu.edu.tr',           'kisaltma' => 'AGU'],
            ['baslik' => 'Adana Alparslan Türkeş Bilim ve Teknoloji Üniversitesi','il' => 1,  'mailUzanti' => 'adanabtu.edu.tr',      'kisaltma' => 'AATBTÜ'],
            ['baslik' => 'Adıyaman Üniversitesi',                             'il' => 2,  'mailUzanti' => 'adiyaman.edu.tr',      'kisaltma' => 'ADÜ'],
            ['baslik' => 'Afyon Kocatepe Üniversitesi',                       'il' => 3,  'mailUzanti' => 'aku.edu.tr',           'kisaltma' => 'AKÜ'],
            ['baslik' => 'Afyonkarahisar Sağlık Bilimleri Üniversitesi',       'il' => 3,  'mailUzanti' => 'afsu.edu.tr',          'kisaltma' => 'AFSU'],
            ['baslik' => 'Ağrı İbrahim Çeçen Üniversitesi',                   'il' => 4,  'mailUzanti' => 'agri.edu.tr',          'kisaltma' => 'AİÇÜ'],
            ['baslik' => 'Aksaray Üniversitesi',                              'il' => 68, 'mailUzanti' => 'aksaray.edu.tr',       'kisaltma' => 'AKSU'],
            ['baslik' => 'Amasya Üniversitesi',                               'il' => 5,  'mailUzanti' => 'amasya.edu.tr',        'kisaltma' => 'AMÜ'],
            ['baslik' => 'Ankara Hacı Bayram Veli Üniversitesi',              'il' => 6,  'mailUzanti' => 'hacibayram.edu.tr',    'kisaltma' => 'HBVÜ'],
            ['baslik' => 'Ankara Müzik ve Güzel Sanatlar Üniversitesi',       'il' => 6,  'mailUzanti' => 'mgu.edu.tr',           'kisaltma' => 'MGU'],
            ['baslik' => 'Ankara Sosyal Bilimler Üniversitesi',               'il' => 6,  'mailUzanti' => 'asbu.edu.tr',          'kisaltma' => 'ASBU'],
            ['baslik' => 'Ankara Üniversitesi',                               'il' => 6,  'mailUzanti' => 'ankara.edu.tr',        'kisaltma' => 'ANÜ'],
            ['baslik' => 'Antalya Akev Üniversitesi (Vakıf)',                 'il' => 7,  'mailUzanti' => 'antalyaakev.edu.tr',   'kisaltma' => 'AAKÜ'],
            ['baslik' => 'Antalya Bilim Üniversitesi (Vakıf)',                'il' => 7,  'mailUzanti' => 'antalya.edu.tr',       'kisaltma' => 'ABÜ'],
            ['baslik' => 'Ardahan Üniversitesi',                              'il' => 75, 'mailUzanti' => 'ardahan.edu.tr',       'kisaltma' => 'ARDÜ'],
            ['baslik' => 'Artvin Çoruh Üniversitesi',                         'il' => 8,  'mailUzanti' => 'artvin.edu.tr',        'kisaltma' => 'ACÜ'],
            ['baslik' => 'Atatürk Üniversitesi',                              'il' => 25, 'mailUzanti' => 'atauni.edu.tr',        'kisaltma' => 'ATÜ'],
            ['baslik' => 'Bahçeşehir Üniversitesi (Vakıf)',                   'il' => 34, 'mailUzanti' => 'bahcesehir.edu.tr',    'kisaltma' => 'BAÜ'],
            ['baslik' => 'Balıkesir Üniversitesi',                            'il' => 10, 'mailUzanti' => 'balikesir.edu.tr',     'kisaltma' => 'BALÜ'],
            ['baslik' => 'Bandırma Onyedi Eylül Üniversitesi',                'il' => 10, 'mailUzanti' => 'bandirma.edu.tr',      'kisaltma' => 'BOEÜ'],
            ['baslik' => 'Bartın Üniversitesi',                               'il' => 74, 'mailUzanti' => 'bartin.edu.tr',        'kisaltma' => 'BARÜ'],
            ['baslik' => 'Batman Üniversitesi',                               'il' => 72, 'mailUzanti' => 'batman.edu.tr',        'kisaltma' => 'BATÜ'],
            ['baslik' => 'Bayburt Üniversitesi',                              'il' => 69, 'mailUzanti' => 'bayburt.edu.tr',       'kisaltma' => 'BAYÜ'],
            ['baslik' => 'Beykent Üniversitesi (Vakıf)',                     'il' => 34, 'mailUzanti' => 'beykent.edu.tr',       'kisaltma' => 'BEYÜ'],
            ['baslik' => 'Bezmialem Vakıf Üniversitesi (Vakıf)',             'il' => 34, 'mailUzanti' => 'bezmialem.edu.tr',     'kisaltma' => 'BEZÜ'],
            ['baslik' => 'Bilecik Şeyh Edebali Üniversitesi',                'il' => 11, 'mailUzanti' => 'bilecik.edu.tr',       'kisaltma' => 'BSEÜ'],
            ['baslik' => 'Bingöl Üniversitesi',                               'il' => 12, 'mailUzanti' => 'bingol.edu.tr',        'kisaltma' => 'BINGÜ'],
            ['baslik' => 'Bitlis Eren Üniversitesi',                          'il' => 13, 'mailUzanti' => 'bitliseren.edu.tr',    'kisaltma' => 'BİEÜ'],
            ['baslik' => 'Boğaziçi Üniversitesi',                             'il' => 34, 'mailUzanti' => 'boun.edu.tr',          'kisaltma' => 'BÜ'],
            ['baslik' => 'Bolu Abant İzzet Baysal Üniversitesi',              'il' => 14, 'mailUzanti' => 'ibu.edu.tr',           'kisaltma' => 'BAİBU'],
            ['baslik' => 'Bursa Teknik Üniversitesi',                         'il' => 16, 'mailUzanti' => 'btu.edu.tr',           'kisaltma' => 'BTÜ'],
            ['baslik' => 'Bursa Uludağ Üniversitesi',                         'il' => 16, 'mailUzanti' => 'uludag.edu.tr',        'kisaltma' => 'BÜÜ'],
            ['baslik' => 'Çanakkale Onsekiz Mart Üniversitesi',               'il' => 17, 'mailUzanti' => 'comu.edu.tr',          'kisaltma' => 'ÇOMÜ'],
            ['baslik' => 'Çankırı Karatekin Üniversitesi',                    'il' => 18, 'mailUzanti' => 'karatekin.edu.tr',     'kisaltma' => 'ÇKÜ'],
            ['baslik' => 'Çukurova Üniversitesi',                             'il' => 1,  'mailUzanti' => 'cu.edu.tr',            'kisaltma' => 'ÇÜ'],
            ['baslik' => 'Demiroğlu Bilim Üniversitesi (Vakıf)',              'il' => 34, 'mailUzanti' => 'bilim.edu.tr',         'kisaltma' => 'DBÜ'],
            ['baslik' => 'Dicle Üniversitesi',                                'il' => 21, 'mailUzanti' => 'dicle.edu.tr',         'kisaltma' => 'DİÜ'],
            ['baslik' => 'Dokuz Eylül Üniversitesi',                           'il' => 35, 'mailUzanti' => 'deu.edu.tr',           'kisaltma' => 'DEÜ'],
            ['baslik' => 'Düzce Üniversitesi',                                 'il' => 81, 'mailUzanti' => 'duzce.edu.tr',         'kisaltma' => 'DÜÜ'],
            ['baslik' => 'Ege Üniversitesi',                                   'il' => 35, 'mailUzanti' => 'ege.edu.tr',           'kisaltma' => 'EÜ'],
            ['baslik' => 'Erciyes Üniversitesi',                               'il' => 38, 'mailUzanti' => 'erciyes.edu.tr',       'kisaltma' => 'ERÜ'],
            ['baslik' => 'Erzincan Binali Yıldırım Üniversitesi',              'il' => 24, 'mailUzanti' => 'ebyu.edu.tr',          'kisaltma' => 'EBYÜ'],
            ['baslik' => 'Erzurum Teknik Üniversitesi',                        'il' => 25, 'mailUzanti' => 'erzurum.edu.tr',       'kisaltma' => 'ETÜ'],
            ['baslik' => 'Eskişehir Osmangazi Üniversitesi',                   'il' => 26, 'mailUzanti' => 'ogu.edu.tr',           'kisaltma' => 'EOÜ'],
            ['baslik' => 'Eskişehir Teknik Üniversitesi',                      'il' => 26, 'mailUzanti' => 'eskisehir.edu.tr',     'kisaltma' => 'ESTÜ'],
            ['baslik' => 'Fırat Üniversitesi',                                 'il' => 23, 'mailUzanti' => 'firat.edu.tr',         'kisaltma' => 'FÜ'],
            ['baslik' => 'Galatasaray Üniversitesi',                           'il' => 34, 'mailUzanti' => 'gsu.edu.tr',           'kisaltma' => 'GSÜ'],
            ['baslik' => 'Gaziantep İslam Bilim ve Teknoloji Üniversitesi',     'il' => 27, 'mailUzanti' => 'gibtu.edu.tr',         'kisaltma' => 'GİBTÜ'],
            ['baslik' => 'Gaziantep Üniversitesi',                             'il' => 27, 'mailUzanti' => 'gantep.edu.tr',        'kisaltma' => 'GAÜ'],
            ['baslik' => 'Gaziosmanpaşa Üniversitesi (Tokat Gaziosmanpaşa)',   'il' => 60, 'mailUzanti' => 'gop.edu.tr',           'kisaltma' => 'GOPÜ'],
            ['baslik' => 'Gebze Teknik Üniversitesi',                          'il' => 41, 'mailUzanti' => 'gtu.edu.tr',           'kisaltma' => 'GTÜ'],
            ['baslik' => 'Giresun Üniversitesi',                               'il' => 28, 'mailUzanti' => 'giresun.edu.tr',       'kisaltma' => 'GİRÜ'],
            ['baslik' => 'Gümüşhane Üniversitesi',                             'il' => 29, 'mailUzanti' => 'gumushane.edu.tr',     'kisaltma' => 'GÜMÜ'],
            ['baslik' => 'Hacettepe Üniversitesi',                             'il' => 6,  'mailUzanti' => 'hacettepe.edu.tr',     'kisaltma' => 'HÜ'],
            ['baslik' => 'Hakkari Üniversitesi',                               'il' => 30, 'mailUzanti' => 'hakkari.edu.tr',       'kisaltma' => 'HAKÜ'],
            ['baslik' => 'Hatay Mustafa Kemal Üniversitesi',                  'il' => 31, 'mailUzanti' => 'mku.edu.tr',           'kisaltma' => 'HMKÜ'],
            ['baslik' => 'Harran Üniversitesi',                                'il' => 63, 'mailUzanti' => 'harran.edu.tr',        'kisaltma' => 'HARÜ'],
            ['baslik' => 'Hitit Üniversitesi',                                 'il' => 19, 'mailUzanti' => 'hitit.edu.tr',         'kisaltma' => 'HİTÜ'],
            ['baslik' => 'Iğdır Üniversitesi',                                 'il' => 76, 'mailUzanti' => 'igdir.edu.tr',         'kisaltma' => 'IĞÜ'],
            ['baslik' => 'İbn Haldun Üniversitesi (Vakıf)',                    'il' => 34, 'mailUzanti' => 'ihu.edu.tr',           'kisaltma' => 'İHÜ'],
            ['baslik' => 'İhsan Doğramacı Bilkent Üniversitesi (Vakıf)',       'il' => 6,  'mailUzanti' => 'bilkent.edu.tr',       'kisaltma' => 'BİLKENT'],
            ['baslik' => 'İnönü Üniversitesi',                                'il' => 44, 'mailUzanti' => 'inonu.edu.tr',         'kisaltma' => 'İNÜ'],
            ['baslik' => 'İskenderun Teknik Üniversitesi',                    'il' => 31, 'mailUzanti' => 'iste.edu.tr',          'kisaltma' => 'İSKTÜ'],
            ['baslik' => 'İstanbul 29 Mayıs Üniversitesi (Vakıf)',            'il' => 34, 'mailUzanti' => '29mayis.edu.tr',       'kisaltma' => '29MÜ'],
            ['baslik' => 'İstanbul Arel Üniversitesi (Vakıf)',                'il' => 34, 'mailUzanti' => 'arel.edu.tr',          'kisaltma' => 'AREL'],
            ['baslik' => 'İstanbul Atlas Üniversitesi (Vakıf)',               'il' => 34, 'mailUzanti' => 'atlas.edu.tr',         'kisaltma' => 'ATLAS'],
            ['baslik' => 'İstanbul Aydın Üniversitesi (Vakıf)',               'il' => 34, 'mailUzanti' => 'aydin.edu.tr',         'kisaltma' => 'AYDÜ'],
            ['baslik' => 'İstanbul Beykent Üniversitesi (Vakıf)',             'il' => 34, 'mailUzanti' => 'beykent.edu.tr',       'kisaltma' => 'İBEYÜ'],
            ['baslik' => 'İstanbul Bilgi Üniversitesi (Vakıf)',               'il' => 34, 'mailUzanti' => 'bilgi.edu.tr',         'kisaltma' => 'BİLGİ'],
            ['baslik' => 'İstanbul Esenyurt Üniversitesi (Vakıf)',            'il' => 34, 'mailUzanti' => 'esenyurt.edu.tr',      'kisaltma' => 'ESENYURT'],
            ['baslik' => 'İstanbul Galata Üniversitesi (Vakıf)',              'il' => 34, 'mailUzanti' => 'galata.edu.tr',        'kisaltma' => 'GALATA'],
            ['baslik' => 'İstanbul Gedik Üniversitesi (Vakıf)',               'il' => 34, 'mailUzanti' => 'gedik.edu.tr',         'kisaltma' => 'GEDİK'],
            ['baslik' => 'İstanbul Gelişim Üniversitesi (Vakıf)',             'il' => 34, 'mailUzanti' => 'gelisim.edu.tr',       'kisaltma' => 'GELİŞİM'],
            ['baslik' => 'İstanbul Kent Üniversitesi (Vakıf)',                'il' => 34, 'mailUzanti' => 'kent.edu.tr',          'kisaltma' => 'KENT'],
            ['baslik' => 'İstanbul Kültür Üniversitesi (Vakıf)',              'il' => 34, 'mailUzanti' => 'iku.edu.tr',           'kisaltma' => 'İKU'],
            ['baslik' => 'İstanbul Medeniyet Üniversitesi',                   'il' => 34, 'mailUzanti' => 'medeniyet.edu.tr',     'kisaltma' => 'MEDENİYET'],
            ['baslik' => 'İstanbul Medipol Üniversitesi (Vakıf)',             'il' => 34, 'mailUzanti' => 'medipol.edu.tr',       'kisaltma' => 'MEDİPOL'],
            ['baslik' => 'İstanbul Okan Üniversitesi (Vakıf)',                'il' => 34, 'mailUzanti' => 'okan.edu.tr',          'kisaltma' => 'OKAN'],
            ['baslik' => 'İstanbul Rumeli Üniversitesi (Vakıf)',              'il' => 34, 'mailUzanti' => 'rumeli.edu.tr',        'kisaltma' => 'RUMELİ'],
            ['baslik' => 'İstanbul Sabahattin Zaim Üniversitesi (Vakıf)',      'il' => 34, 'mailUzanti' => 'izu.edu.tr',           'kisaltma' => 'SAZÜ'],
            ['baslik' => 'İstanbul Teknik Üniversitesi',                     'il' => 34, 'mailUzanti' => 'itu.edu.tr',           'kisaltma' => 'İTÜ'],
            ['baslik' => 'İstanbul Ticaret Üniversitesi (Vakıf)',             'il' => 34, 'mailUzanti' => 'iticu.edu.tr',         'kisaltma' => 'TİCÜ'],
            ['baslik' => 'İstanbul Üniversitesi',                            'il' => 34, 'mailUzanti' => 'istanbul.edu.tr',      'kisaltma' => 'İÜ'],
            ['baslik' => 'İstanbul Yeni Yüzyıl Üniversitesi (Vakıf)',          'il' => 34, 'mailUzanti' => 'yeniyuzyil.edu.tr',    'kisaltma' => 'YYÜ'],
            ['baslik' => 'İstinye Üniversitesi (Vakıf)',                     'il' => 34, 'mailUzanti' => 'istinye.edu.tr',       'kisaltma' => 'İSTİNYE'],
            ['baslik' => 'İzmir Bakırçay Üniversitesi',                       'il' => 35, 'mailUzanti' => 'bakircay.edu.tr',      'kisaltma' => 'İZBAK'],
            ['baslik' => 'İzmir Demokrasi Üniversitesi',                      'il' => 35, 'mailUzanti' => 'idu.edu.tr',           'kisaltma' => 'İZDÜ'],
            ['baslik' => 'İzmir Ekonomi Üniversitesi (Vakıf)',                'il' => 35, 'mailUzanti' => 'ieu.edu.tr',           'kisaltma' => 'İZEK'],
            ['baslik' => 'İzmir Katip Çelebi Üniversitesi',                   'il' => 35, 'mailUzanti' => 'ikcu.edu.tr',          'kisaltma' => 'İZKÇ'],
            ['baslik' => 'İzmir Tınaztepe Üniversitesi (Vakıf)',              'il' => 35, 'mailUzanti' => 'tinaztepe.edu.tr',     'kisaltma' => 'İZTÜ'],
            ['baslik' => 'İzmir Yüksek Teknoloji Enstitüsü',                  'il' => 35, 'mailUzanti' => 'iyte.edu.tr',          'kisaltma' => 'İYTE'],
            ['baslik' => 'Kadir Has Üniversitesi (Vakıf)',                    'il' => 34, 'mailUzanti' => 'khas.edu.tr',          'kisaltma' => 'KHAS'],
            ['baslik' => 'Kafkas Üniversitesi',                               'il' => 36, 'mailUzanti' => 'kafkas.edu.tr',        'kisaltma' => 'KAFKÜ'],
            ['baslik' => 'Kahramanmaraş İstiklal Üniversitesi',               'il' => 46, 'mailUzanti' => 'istiklal.edu.tr',      'kisaltma' => 'KİÜ'],
            ['baslik' => 'Kahramanmaraş Sütçü İmam Üniversitesi',             'il' => 46, 'mailUzanti' => 'ksu.edu.tr',           'kisaltma' => 'KSİÜ'],
            ['baslik' => 'Kapadokya Üniversitesi (Vakıf)',                    'il' => 50, 'mailUzanti' => 'kapadokya.edu.tr',     'kisaltma' => 'KAPÜ'],
            ['baslik' => 'Karabük Üniversitesi',                              'il' => 78, 'mailUzanti' => 'karabuk.edu.tr',       'kisaltma' => 'KARABÜ'],
            ['baslik' => 'Karadeniz Teknik Üniversitesi',                     'il' => 61, 'mailUzanti' => 'ktu.edu.tr',           'kisaltma' => 'KTÜ'],
            ['baslik' => 'Karamanoğlu Mehmetbey Üniversitesi',                'il' => 70, 'mailUzanti' => 'kmu.edu.tr',           'kisaltma' => 'KMÜ'],
            ['baslik' => 'Kastamonu Üniversitesi',                            'il' => 37, 'mailUzanti' => 'kastamonu.edu.tr',     'kisaltma' => 'KASTÜ'],
            ['baslik' => 'Kayseri Üniversitesi',                              'il' => 38, 'mailUzanti' => 'kayseri.edu.tr',       'kisaltma' => 'KAYSÜ'],
            ['baslik' => 'Kırıkkale Üniversitesi',                            'il' => 71, 'mailUzanti' => 'kku.edu.tr',           'kisaltma' => 'KIRÜ'],
            ['baslik' => 'Kırklareli Üniversitesi',                           'il' => 39, 'mailUzanti' => 'klu.edu.tr',           'kisaltma' => 'KIRKÜ'],
            ['baslik' => 'Kilis 7 Aralık Üniversitesi',                       'il' => 79, 'mailUzanti' => 'kilis.edu.tr',         'kisaltma' => 'K7AÜ'],
            ['baslik' => 'Kocaeli Üniversitesi',                              'il' => 41, 'mailUzanti' => 'kocaeli.edu.tr',       'kisaltma' => 'KOKÜ'],
            ['baslik' => 'Konya Gıda ve Tarım Üniversitesi (Vakıf)',          'il' => 42, 'mailUzanti' => 'gidatarim.edu.tr',     'kisaltma' => 'KGTVÜ'],
            ['baslik' => 'Konya Teknik Üniversitesi',                         'il' => 42, 'mailUzanti' => 'ktun.edu.tr',          'kisaltma' => 'KTUN'],
            ['baslik' => 'Kütahya Dumlupınar Üniversitesi',                   'il' => 43, 'mailUzanti' => 'dpu.edu.tr',           'kisaltma' => 'KDÜ'],
            ['baslik' => 'Kütahya Sağlık Bilimleri Üniversitesi',             'il' => 43, 'mailUzanti' => 'ksbu.edu.tr',          'kisaltma' => 'KSBÜ'],
            ['baslik' => 'Malatya Turgut Özal Üniversitesi',                  'il' => 44, 'mailUzanti' => 'mtu.edu.tr',           'kisaltma' => 'MTÜ'],
            ['baslik' => 'Manisa Celal Bayar Üniversitesi',                   'il' => 45, 'mailUzanti' => 'cbu.edu.tr',           'kisaltma' => 'CBÜ'],
            ['baslik' => 'Mardin Artuklu Üniversitesi',                       'il' => 47, 'mailUzanti' => 'artuklu.edu.tr',       'kisaltma' => 'MAÜ'],
            ['baslik' => 'Marmara Üniversitesi',                              'il' => 34, 'mailUzanti' => 'marmara.edu.tr',       'kisaltma' => 'MARÜ'],
            ['baslik' => 'Mersin Üniversitesi',                               'il' => 33, 'mailUzanti' => 'mersin.edu.tr',        'kisaltma' => 'MERÜ'],
            ['baslik' => 'Mimar Sinan Güzel Sanatlar Üniversitesi',           'il' => 34, 'mailUzanti' => 'msgsu.edu.tr',         'kisaltma' => 'MSGSU'],
            ['baslik' => 'Muğla Sıtkı Koçman Üniversitesi',                   'il' => 48, 'mailUzanti' => 'mu.edu.tr',            'kisaltma' => 'MSKÜ'],
            ['baslik' => 'Munzur Üniversitesi',                               'il' => 62, 'mailUzanti' => 'munzur.edu.tr',        'kisaltma' => 'MUNÜ'],
            ['baslik' => 'Mustafa Kemal Üniversitesi (Hatay Mustafa Kemal)',  'il' => 31, 'mailUzanti' => 'mku.edu.tr',           'kisaltma' => 'MKU'],
            ['baslik' => 'Muş Alparslan Üniversitesi',                        'il' => 49, 'mailUzanti' => 'alparslan.edu.tr',     'kisaltma' => 'MALÜ'],
            ['baslik' => 'Nevşehir Hacı Bektaş Veli Üniversitesi',            'il' => 50, 'mailUzanti' => 'nevsehir.edu.tr',      'kisaltma' => 'NHBVÜ'],
            ['baslik' => 'Niğde Ömer Halisdemir Üniversitesi',                'il' => 51, 'mailUzanti' => 'ohu.edu.tr',           'kisaltma' => 'NOHÜ'],
            ['baslik' => 'Nuh Naci Yazgan Üniversitesi (Vakıf)',              'il' => 38, 'mailUzanti' => 'nny.edu.tr',           'kisaltma' => 'NNYÜ'],
            ['baslik' => 'Ondokuz Mayıs Üniversitesi',                        'il' => 55, 'mailUzanti' => 'omu.edu.tr',           'kisaltma' => 'OMÜ'],
            ['baslik' => 'Ordu Üniversitesi',                                  'il' => 52, 'mailUzanti' => 'odu.edu.tr',           'kisaltma' => 'ORDU'],
            ['baslik' => 'Orta Doğu Teknik Üniversitesi',                     'il' => 6,  'mailUzanti' => 'metu.edu.tr',          'kisaltma' => 'ODTÜ'],
            ['baslik' => 'Osmaniye Korkut Ata Üniversitesi',                  'il' => 80, 'mailUzanti' => 'osmaniye.edu.tr',      'kisaltma' => 'OKAÜ'],
            ['baslik' => 'Ostim Teknik Üniversitesi (Vakıf)',                'il' => 6,  'mailUzanti' => 'ostimteknik.edu.tr',   'kisaltma' => 'OSTİM'],
            ['baslik' => 'Pamukkale Üniversitesi',                            'il' => 20, 'mailUzanti' => 'pau.edu.tr',           'kisaltma' => 'PAMÜ'],
            ['baslik' => 'Recep Tayyip Erdoğan Üniversitesi',                 'il' => 53, 'mailUzanti' => 'erdogan.edu.tr',       'kisaltma' => 'RTEÜ'],
            ['baslik' => 'Sağlık Bilimleri Üniversitesi',                     'il' => 34, 'mailUzanti' => 'sbu.edu.tr',           'kisaltma' => 'SBU'],
            ['baslik' => 'Sakarya Uygulamalı Bilimler Üniversitesi',          'il' => 54, 'mailUzanti' => 'subu.edu.tr',          'kisaltma' => 'SUBÜ'],
            ['baslik' => 'Sakarya Üniversitesi',                              'il' => 54, 'mailUzanti' => 'sakarya.edu.tr',       'kisaltma' => 'SAKU'],
            ['baslik' => 'Samsun Üniversitesi',                               'il' => 55, 'mailUzanti' => 'samsun.edu.tr',        'kisaltma' => 'SAMÜ'],
            ['baslik' => 'Selçuk Üniversitesi',                               'il' => 42, 'mailUzanti' => 'selcuk.edu.tr',        'kisaltma' => 'SELÜ'],
            ['baslik' => 'Siirt Üniversitesi',                                'il' => 56, 'mailUzanti' => 'siirt.edu.tr',         'kisaltma' => 'SİÜ'],
            ['baslik' => 'Sinop Üniversitesi',                                'il' => 57, 'mailUzanti' => 'sinop.edu.tr',         'kisaltma' => 'SINÜ'],
            ['baslik' => 'Sivas Bilim ve Teknoloji Üniversitesi',             'il' => 58, 'mailUzanti' => 'sivas.edu.tr',         'kisaltma' => 'SBTÜ'],
            ['baslik' => 'Sivas Cumhuriyet Üniversitesi',                     'il' => 58, 'mailUzanti' => 'cumhuriyet.edu.tr',    'kisaltma' => 'SCÜ'],
            ['baslik' => 'Şırnak Üniversitesi',                               'il' => 73, 'mailUzanti' => 'sirnak.edu.tr',        'kisaltma' => 'ŞIRÜ'],
            ['baslik' => 'Tarsus Üniversitesi',                               'il' => 33, 'mailUzanti' => 'tarsus.edu.tr',        'kisaltma' => 'TARSÜ'],
            ['baslik' => 'Ted Üniversitesi (Vakıf)',                          'il' => 6,  'mailUzanti' => 'tedu.edu.tr',          'kisaltma' => 'TEDÜ'],
            ['baslik' => 'Tekirdağ Namık Kemal Üniversitesi',                 'il' => 59, 'mailUzanti' => 'nku.edu.tr',           'kisaltma' => 'TNKU'],
            ['baslik' => 'Tokat Gaziosmanpaşa Üniversitesi',                  'il' => 60, 'mailUzanti' => 'gop.edu.tr',           'kisaltma' => 'TGKÜ'],
            ['baslik' => 'Trabzon Üniversitesi',                              'il' => 61, 'mailUzanti' => 'trabzon.edu.tr',       'kisaltma' => 'TRAÜ'],
            ['baslik' => 'Trakya Üniversitesi',                               'il' => 22, 'mailUzanti' => 'trakya.edu.tr',        'kisaltma' => 'TRAKÜ'],
            ['baslik' => 'Türk Alman Üniversitesi',                           'il' => 34, 'mailUzanti' => 'tau.edu.tr',           'kisaltma' => 'TAÜ'],
            ['baslik' => 'Ufuk Üniversitesi (Vakıf)',                         'il' => 6,  'mailUzanti' => 'ufuk.edu.tr',          'kisaltma' => 'UFÜ'],
            ['baslik' => 'Uşak Üniversitesi',                                 'il' => 64, 'mailUzanti' => 'usak.edu.tr',          'kisaltma' => 'UŞÜ'],
            ['baslik' => 'Van Yüzüncü Yıl Üniversitesi',                      'il' => 65, 'mailUzanti' => 'yyu.edu.tr',           'kisaltma' => 'VYYÜ'],
            ['baslik' => 'Yalova Üniversitesi',                               'il' => 77, 'mailUzanti' => 'yalova.edu.tr',        'kisaltma' => 'YALÜ'],
            ['baslik' => 'Yaşar Üniversitesi (Vakıf)',                        'il' => 35, 'mailUzanti' => 'yasar.edu.tr',         'kisaltma' => 'YAŞÜ'],
            ['baslik' => 'Yıldız Teknik Üniversitesi',                        'il' => 34, 'mailUzanti' => 'yildiz.edu.tr',        'kisaltma' => 'YTU'],
            ['baslik' => 'Yozgat Bozok Üniversitesi',                         'il' => 66, 'mailUzanti' => 'bozok.edu.tr',         'kisaltma' => 'YBZÜ'],
            ['baslik' => 'Zonguldak Bülent Ecevit Üniversitesi',              'il' => 67, 'mailUzanti' => 'beun.edu.tr',          'kisaltma' => 'ZBEÜ'],
            ['baslik' => 'UniPortal',              'il' => 59, 'mailUzanti' => 'uniportal.org.tr',          'kisaltma' => 'uniportal'],
        ];

        $faker = Faker::create("tr_TR");

        foreach ($universiteler as $uni) {
            Isletme::create([
                'isletme_turleri_id' => 1,
                'iller_id'           => $uni['il'],
                'referans_kodu'      => strtoupper(Str::random(8)),
                'referans'           => null,
                'baslik'             => $uni['baslik'],
                'adres'              => $faker->address,
                'kisaltma'           => $uni['kisaltma'],
                'mailUzanti'         => $uni['mailUzanti'],
                'logoUrl'            => 'https://placehold.co/128x128',
                'websiteUrl'         => $faker->url,
                'xUrl'               => 'x.com/' . $faker->userName,
                'instagramUrl'       => 'instagram.com/' . $faker->userName,
                'linkedinUrl'        => 'linkedin.com/' . $faker->userName,
                'digerUrl'           => $faker->url,
            ]);
        }

        $bizim = Isletme::find(143);

        $bizim->update([
            'logoUrl' => 'image/_TNKU_LOGO_TR.png',
        ]);
    }

    // function generateKisaltma($name)
    // {
    //     // Parantez içindeki ifadeleri kaldır (örneğin: "(Vakıf)")
    //     $name = preg_replace('/\s*\(.*?\)/', '', $name);

    //     // Boşluklardan kelimelere ayır
    //     $words = preg_split('/\s+/', $name);
    //     $kisaltma = '';

    //     // Her kelimenin ilk harfini al
    //     foreach ($words as $word) {
    //         if (!empty($word)) {
    //             $kisaltma .= mb_substr($word, 0, 1);
    //         }
    //     }

    //     // Türkçe karakterleri İngilizce karşılıklarına çevir
    //     $search  = ['Ç', 'ç', 'Ğ', 'ğ', 'Ö', 'ö', 'Ş', 'ş', 'Ü', 'ü', 'İ', 'ı'];
    //     $replace = ['C', 'c', 'G', 'g', 'O', 'o', 'S', 's', 'U', 'u', 'I', 'i'];
    //     $kisaltma = str_replace($search, $replace, $kisaltma);

    //     return mb_strtoupper($kisaltma);
    // }
}
