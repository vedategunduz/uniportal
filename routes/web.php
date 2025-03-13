<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\NotAuthMiddleware;

use App\Http\Controllers\AnasayfaController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Yonetim\BirimlerController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\EtkinlikController;
use App\Http\Controllers\EtkinlikKatilimController;
use App\Http\Controllers\EtkinlikYorumController;
use App\Http\Controllers\IletisimController;
use App\Http\Controllers\KanalController;
use App\Http\Controllers\KullaniciPaylasimController;
use App\Http\Controllers\MesajController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Yonetim\ToplantiController;
use App\Http\Controllers\Yonetim\EtkinlikController as YonetimEtkinlikController;
use App\Http\Controllers\Yonetim\KampanyaController;
use App\Http\Controllers\Yonetim\KullaniciController;
use App\Http\Controllers\Yonetim\YonetimController;

Route::prefix('/')->name('main.')->group(function () {
    Route::get('/', [AnasayfaController::class, 'index'])->name('index');

    Route::get('/hakkinda', function () {
        return view('main.hakkinda');
    })->name('hakkinda');

    Route::prefix('iletisim')->name('iletisim.')->group(function () {
        Route::get('/', [IletisimController::class, 'index'])->name('index');
        Route::post('/', [IletisimController::class, 'store'])->name('store');
    });
});

Route::prefix('etkinlikler')->name('etkinlikler.')->group(function () {
    Route::get('/', [EtkinlikController::class, 'index'])->name('index');

    Route::prefix('{etkinlik_id}')->group(function () {
        Route::get('/', [EtkinlikController::class, 'show'])->name('show');
        Route::get('detay', [EtkinlikController::class, 'detay'])->name('detay');
        Route::patch('begenToggle', [EtkinlikController::class, 'begenToggle'])->name('begenToggle');

        Route::get('/views', [EtkinlikController::class, 'getViews'])->name('views');
        Route::post('/views', [EtkinlikController::class, 'incrementView'])->name('incrementView');

        Route::prefix('katil')->name('katil.')->group(function () {
            Route::get('/', [EtkinlikKatilimController::class, 'show'])->name('show');
            Route::post('/', [EtkinlikKatilimController::class, 'store'])->name('store');
        });

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

        // Route::prefix('etkinlikler')->name('etkinlikler.')->group(function () {
        //     Route::get('/', [EventController::class, 'index'])->name('index');
        //     Route::get('/show/{isletmeler_id}', [EventController::class, 'getDataTableDatas'])->name('show');
        //     Route::post('modalGetir/{id}', [EventController::class, 'modalGetir']);
        //     Route::post('silmeModalGetir/{id}', [EventController::class, 'silmeModalGetir']);
        //     Route::post('ekle', [EventController::class, 'store']);
        //     Route::post('guncelle', [EventController::class, 'update']);
        //     Route::post('sil', [EventController::class, 'etkinlikSil']);
        //     Route::post('resmi-kaldir/{id}', [ResimController::class, 'destroy']);

        //     Route::post('dosya-yukle', [EventController::class, 'dosyaYukle'])->name('dosya-yukle');

        //     Route::prefix('katilim')->name('katilim.')->group(function () {
        //         Route::get('onayla/{parametre}', [ZiyaretKatilimController::class, 'onay'])->name('onayla');
        //         Route::get('red/{parametre}', [ZiyaretKatilimController::class, 'red'])->name('red');
        //         Route::get('download-ics/{id}', [ZiyaretKatilimController::class, 'downloadIcs'])->name('download-ics');
        //     });
        // });

        Route::prefix('etkinlikler')->name('etkinlikler.')->group(function () {
            Route::get('/', [YonetimEtkinlikController::class, 'index'])->name('index');
            Route::post('/', [YonetimEtkinlikController::class, 'store'])->name('store');
            Route::get('ekle', [YonetimEtkinlikController::class, 'create'])->name('create');
            Route::get('dataTable/{isletme_id}', [YonetimEtkinlikController::class, 'dataTable'])->name('dataTable');

            Route::prefix('{etkinlik_id}')->group(function () {
                Route::get('/', [YonetimEtkinlikController::class, 'show'])->name('show');
                Route::get('edit', [YonetimEtkinlikController::class, 'edit'])->name('edit');
                Route::patch('/', [YonetimEtkinlikController::class, 'update'])->name('update');
                Route::delete('/', [YonetimEtkinlikController::class, 'destroy'])->name('destroy');

                Route::prefix('katilimcilar')->name('katilimcilar.')->group(function () {
                    Route::get('/', [YonetimEtkinlikController::class, 'katilimcilar'])->name('show');
                    Route::post('/', [YonetimEtkinlikController::class, 'cevap'])->name('cevap');
                });

                Route::get('{kullanici_id}/sohbet', [YonetimEtkinlikController::class, 'sohbet'])->name('sohbet');
            });
        });

        Route::prefix('toplantilar')->name('toplantilar.')->group(function () {
            Route::prefix('ziyaretler')->name('ziyaretler.')->group(function () {
                Route::get('/', [ToplantiController::class, 'index'])->name('index');
                Route::post('/', [ToplantiController::class, 'store'])->name('store');
                Route::get('ekle', [ToplantiController::class, 'create'])->name('create');
                Route::get('dataTable/{isletme_id}', [ToplantiController::class, 'dataTable'])->name('dataTable');

                Route::get('search/{isletme_id}/{q}/{qNot?}', [ToplantiController::class, 'search'])->name('search');

                Route::prefix('{etkinlik_id}')->group(function () {
                    Route::get('/', [ToplantiController::class, 'show'])->name('show');
                    Route::get('edit', [ToplantiController::class, 'edit'])->name('edit');
                    Route::patch('/', [ToplantiController::class, 'update'])->name('update');
                    Route::delete('/', [ToplantiController::class, 'destroy'])->name('destroy');
                    Route::get('katilimciListesi/{type}', [ToplantiController::class, 'katilimciListesi'])->name('katilimciListesi');
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

        Route::prefix('kampanyalar')->name('kampanyalar.')->group(function () {
            Route::get('/', [KampanyaController::class, 'index'])->name('index');
            Route::post('/', [KampanyaController::class, 'store'])->name('store');
            Route::get('ekle', [KampanyaController::class, 'create'])->name('create');
            Route::get('dataTable/{isletme_id}', [KampanyaController::class, 'dataTable'])->name('dataTable');

            Route::prefix('{etkinlik_id}')->group(function () {
                Route::get('sohbet', [KampanyaController::class, 'sohbet'])->name('sohbet');
                Route::get('/', [KampanyaController::class, 'show'])->name('show');
                Route::get('edit', [KampanyaController::class, 'edit'])->name('edit');
                Route::patch('/', [KampanyaController::class, 'update'])->name('update');
                Route::delete('/', [KampanyaController::class, 'destroy'])->name('destroy');
            });
        });

        Route::prefix('kullanici')->name('kullanici.')->group(function () {
            Route::get('/{kullanici_id?}', [ProfilController::class, 'show'])->name('show');

            Route::prefix('paylasim')->name('paylasim.')->group(function () {
                Route::post('/', [KullaniciPaylasimController::class, 'store'])->name('store');
            });
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

Route::prefix('errors')->name('errors.')->group(function () {
    Route::get('/404', function () {
        return view('errors.404');
    })->name('404');
});
