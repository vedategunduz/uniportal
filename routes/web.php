<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\NotAuthMiddleware;

use App\Http\Controllers\AnasayfaController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Yonetim\BirimlerController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\EtkinlikController;
use App\Http\Controllers\EtkinlikYorumController;
use App\Http\Controllers\KanalController;
use App\Http\Controllers\MesajController;
use App\Http\Controllers\Personel\PersonelController;
use App\Http\Controllers\Yonetim\EventController;
use App\Http\Controllers\ResimController;
use App\Http\Controllers\Toplanti\ToplantiController;
use App\Http\Controllers\Toplanti\Ziyaret\ZiyaretController;
use App\Http\Controllers\Toplanti\Ziyaret\ZiyaretKatilimController;
use App\Http\Controllers\Yonetim\KullaniciController;
use App\Http\Controllers\Yonetim\YonetimController;

Route::prefix('/')->name('main.')->group(function () {
    Route::get('/', [AnasayfaController::class, 'index'])->name('index');

    Route::get('/hakkinda', function () {
        return view('main.hakkinda');
    })->name('hakkinda');

    Route::get('/iletisim', function () {
        return view('main.iletisim');
    })->name('iletisim');
});

Route::prefix('personel')->name('personel.')->group(function () {
    Route::get('/{kullanici_id}', [PersonelController::class, 'show'])->name('profil');
});

Route::prefix('etkinlikler')->name('etkinlikler.')->group(function () {
    Route::get('/', [EtkinlikController::class, 'index'])->name('index');

    Route::prefix('{etkinlik_id}')->group(function () {
        Route::get('/', [EtkinlikController::class, 'show'])->name('show');
        Route::patch('begenToggle', [EtkinlikController::class, 'begenToggle'])->name('begenToggle');

        Route::prefix('yorum')->name('yorum.')->group(function () {
            Route::post('/', [EtkinlikYorumController::class, 'store'])->name('store');

            Route::prefix('{yorum_id}')->group(function () {
                Route::post('/', [EtkinlikYorumController::class, 'yanitStore'])->name('yanitStore');
                Route::delete('/', [EtkinlikYorumController::class, 'destroy'])->name('destroy');
                Route::patch('begenToggle', [EtkinlikYorumController::class, 'begenToggle'])->name('begenToggle');
            });
        });
    });
});

// Rollere göre menü yönlendirme yapılacak

Route::prefix('yonetim')->name('yonetim.')->group(function () {

    Route::middleware(AuthMiddleware::class)->group(function () {
        Route::get('/', [YonetimController::class, 'index'])->name('index');

        Route::prefix('mesaj')->name('mesaj.')->group(function () {
            Route::get('/', [MesajController::class, 'index'])->name('index');
            Route::post('/', [MesajController::class, 'store'])->name('store');
            Route::post('/dosya', [MesajController::class, 'dosya'])->name('dosya');

            Route::delete('/{mesajId}', [MesajController::class, 'destroy'])->name('destroy');
            Route::patch('/{mesajId}', [MesajController::class, 'update'])->name('update');
            Route::patch('alinti-kaldir/{mesajId}', [MesajController::class, 'alintiKaldir'])->name('alinti-kaldir');

            Route::delete('/okundu/{kanalId}', [MesajController::class, 'okundu'])->name('okundu');
            Route::post('/{mesajId}/emoji/{emojiId}', [MesajController::class, 'emoji'])->name('emoji');

            Route::prefix('kanal')->name('kanal.')->group(function () {
                Route::post('/', [KanalController::class, 'store'])->name('store');
                Route::get('/{kanalId}', [KanalController::class, 'edit'])->name('edit');
                Route::patch('/{kanalId}', [KanalController::class, 'update'])->name('update');
                Route::delete('/{kanalId}', [KanalController::class, 'destroy'])->name('destroy');

                Route::prefix('katilimci')->name('katilimci.')->group(function () {
                    Route::post('/', [KanalController::class, 'katilimciEkle'])->name('store');
                    Route::post('/ara', [KanalController::class, 'katilimciListesi'])->name('list');
                    Route::post('/card', [KanalController::class, 'katilimciCardEkle'])->name('card.ekle');

                    Route::delete('/{kanalId}/{katilimciId}', [KanalController::class, 'katilimciSil'])->name('destroy');
                    Route::patch('/yoneticilik/{kanalId}/{katilimciId}', [KanalController::class, 'yoneticilik'])->name('yoneticilik');
                });
            });
        });

        Route::prefix('birimler')->name('birimler.')->group(function () {
            Route::get('/', [BirimlerController::class, 'index'])->name('index');
            Route::get('/{isletmeler_id}', [BirimlerController::class, 'getTable']);
            Route::post('/modalBirimGoster/{birimler_id}/', [BirimlerController::class, 'modalBirimGoster']);
            Route::post('/birimEkle/{isletmele_id}', [BirimlerController::class, 'birimEkle']);
            Route::post('/birimGuncelle', [BirimlerController::class, 'birimGuncelle']);
            Route::post('/silmeModalContent/{birimler_id}', [BirimlerController::class, 'silmeModalContent']);
            Route::post('/sil', [BirimlerController::class, 'birimSil']);
            Route::post('/birimDegistirmeModalContent', [BirimlerController::class, 'birimDegistirmeModalContent']);
            Route::post('/personelBirimDegistir', [BirimlerController::class, 'personelBirimDegistir']);
            Route::post('/birimeYerlesmemisPersonelModalContent', [BirimlerController::class, 'birimeYerlesmemisPersonelModalContent']);
            Route::post('/birimeYerlesmemisPersoneller', [BirimlerController::class, 'birimeYerlesmemisPersoneller']);
            Route::post('/birimPersonelSil/{id}', [BirimlerController::class, 'birimPersonelSil']);
            Route::post('/birimeYerlesmemisPersonelSayisi/{isletmeler_id}', [BirimlerController::class, 'birimeYerlesmemisPersonelSayisi']);
            Route::post('/personelEklemeListesi/{birimler_id}/{search}', [BirimlerController::class, 'personelEklemeListesi']);
            Route::post('/modal/birimKullanicilari/{id}', [BirimlerController::class, 'getModalIsletmeKullanicilari']);
            Route::post('/personelBirimAta', [BirimlerController::class, 'personelBirimAta']);
        });

        Route::prefix('etkinlikler')->name('etkinlikler.')->group(function () {
            Route::get('/', [EventController::class, 'index'])->name('index');
            Route::get('/show/{isletmeler_id}', [EventController::class, 'getDataTableDatas'])->name('show');
            Route::post('modalGetir/{id}', [EventController::class, 'modalGetir']);
            Route::post('silmeModalGetir/{id}', [EventController::class, 'silmeModalGetir']);
            Route::post('ekle', [EventController::class, 'store']);
            Route::post('guncelle', [EventController::class, 'update']);
            Route::post('sil', [EventController::class, 'etkinlikSil']);
            Route::post('resmi-kaldir/{id}', [ResimController::class, 'destroy']);

            Route::prefix('katilim')->name('katilim.')->group(function () {
                Route::get('onayla/{parametre}', [ZiyaretKatilimController::class, 'onay'])->name('onayla');
                Route::get('red/{parametre}', [ZiyaretKatilimController::class, 'red'])->name('red');
                Route::get('download-ics/{id}', [ZiyaretKatilimController::class, 'downloadIcs'])->name('download-ics');
            });
        });

        Route::prefix('toplantilar')->name('toplantilar.')->group(function () {
            Route::get('/{isletmeler_id}', [ToplantiController::class, 'getDataTableDatas']);

            Route::prefix('ziyaret')->group(function () {
                Route::prefix('talep')->group(function () {
                    Route::get('/', [ToplantiController::class, 'index']);
                    Route::post('/ziyaretTalepModalGetir/{etkinlikler_id?}', [ZiyaretController::class, 'ziyaretTalepModalGetir']);
                    Route::post('/olustur', [ZiyaretController::class, 'store']);
                    Route::post('/duzenle', [ZiyaretController::class, 'duzenle']);

                    Route::prefix('personeller')->group(function () {
                        Route::post('/', [ZiyaretController::class, 'personeller']);
                        Route::post('/yonetici', [ZiyaretController::class, 'kurumPersoneller']);
                    });

                    Route::prefix('personel-card')->group(function () {
                        Route::post('/', [ZiyaretController::class, 'personelCard']);
                        Route::post('davetci', [ZiyaretController::class, 'kurumPersonelCard']);
                    });
                });
            });
        });

        Route::prefix('kullanicilar')->name('kullanicilar.')->group(function () {
            Route::get('/', [KullaniciController::class, 'index']);
            Route::get('{isletmeler_id}', [KullaniciController::class, 'getTable']);
            Route::post('unvanDegistir', [KullaniciController::class, 'unvanDegistir']);

            Route::post('personelSil', [KullaniciController::class, 'personelSil']);
            Route::post('birimdenCikart', [KullaniciController::class, 'birimdenCikart']);
            Route::post('personelGuncelle', [KullaniciController::class, 'personelGuncelle']);

            Route::post('silmeModalGetir', [KullaniciController::class, 'silmeModalGetir']);
            Route::post('birimdenCikarModalGetir', [KullaniciController::class, 'birimdenCikarModalGetir']);
            Route::post('guncelleModalGetir/{kullanicilar_id}', [KullaniciController::class, 'guncelleModalGetir']);

            Route::post('davetGonderModalGetir', [KullaniciController::class, 'davetGonderModalGetir']);

            Route::post('mailKontrol', [KullaniciController::class, 'mailKontrol']);
        });
    });
});

Route::prefix('editor')->name('editor.')->group(function () {
    Route::prefix('file')->name('file.')->group(function () {
        Route::post('upload', [EditorController::class, 'fileUpload'])->name('yukle');
    });

    Route::prefix('image')->name('image.')->group(function () {
        Route::post('upload', [EditorController::class, 'imageUpload'])->name('yukle');
    });
});

Route::prefix('auth')->name('auth.')->group(function () {
    Route::middleware(NotAuthMiddleware::class)->group(function () {
        Route::prefix('giris')->name('giris.')->group(function () {
            Route::get('/', [AuthController::class, 'girisForm'])->name('form');
            Route::post('/', [AuthController::class, 'girisYap'])->name('yap');
        });

        Route::prefix('kayit')->name('kayit.')->group(function () {
            Route::get('/', [AuthController::class, 'kayitForm'])->name('form');
            Route::post('/', [AuthController::class, 'kayitYap'])->name('yap');
        });
    });

    Route::prefix('onay')->name('onay.')->group(function () {
        Route::get('/{token}', [AuthController::class, 'onayla'])->name('onayla');
    });

    // Çıkış rotası
    Route::get('/cikis', [AuthController::class, 'cikis'])->name('cikis')->middleware(AuthMiddleware::class);
});

Route::get('/onizle', function () {
    return view('mail.hesap-onaylama-mail');
});

Route::post('/gitgetir', function () {
    return response()->json([
        'success' => true,
        'html' => view('components.mesaj.mesaj')->render(),
    ]);
});

Route::prefix('errors')->name('errors.')->group(function () {
    Route::get('/404', function () {
        return view('errors.404');
    })->name('404');
});
