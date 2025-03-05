<?php

namespace App\Livewire;

use App\Models\EtkinlikYorum;
use Livewire\Attributes\On;
use Livewire\Component;

class EtkinlikYorumComponent extends Component
{
    public $etkinlikid;
    public $yorumlar;
    public $perPage = 8;
    public $threshold = 10;
    public $totalYorum;
    public $yorumSayisi;
    public $kamuYorumu = 0;

    public function mount($etkinlikid)
    {
        $this->etkinlikid = $etkinlikid;

        $this->totalYorum = EtkinlikYorum::where('etkinlikler_id', $etkinlikid)
            ->whereNull('yanitlanan_etkinlik_yorumlari_id')
            ->where('yorum_tipi', $this->kamuYorumu)

            ->where('aktiflik', 1)
            ->count();

        $this->yorumSayisi = EtkinlikYorum::where('etkinlikler_id', $etkinlikid)
            ->where('yorum_tipi', $this->kamuYorumu)

            ->where('aktiflik', 1)
            ->count();

        $yorumlar = EtkinlikYorum::withCount('begeni')
            ->where('etkinlikler_id', $etkinlikid)
            ->whereNull('yanitlanan_etkinlik_yorumlari_id')
            // Önce beğeni sayısı belirli eşik değer veya üstünde olanları getirir.
            ->orderByRaw("CASE WHEN begeni_count >= ? THEN 0 ELSE 1 END", [$this->threshold])
            // Ardından beğeni sayısına göre (yüksekten düşüğe) sıralar.
            // ->orderByDesc('begeni_count')
            // Son olarak, eklenme tarihine göre (en yeniler önce) sıralar.
            ->orderByDesc('created_at')
            ->where('yorum_tipi', $this->kamuYorumu)
            ->where('aktiflik', 1)
            ->take($this->perPage)
            ->get();

        $this->yorumlar = $yorumlar;
    }

    #[On('yorumEklendi')]
    public function yorumEklendi($eklenenYorum, $tip)
    {
        $eklenenYorum = EtkinlikYorum::find($eklenenYorum['etkinlik_yorumlari_id']);

        if ($tip === 'yanit') {
            // Yanıt ekleniyorsa: Öncelikle ilgili ana yorumu bulalım.
            $parentYorum = EtkinlikYorum::find($eklenenYorum['etkinlik_yorumlari_id']);

            if ($parentYorum) {
                // Ana yorumun yanıtlar koleksiyonuna, yeni yanıtı ekleyin.
                // Burada 'yanitlar' ilişkisinin tanımlı olduğundan emin olun.
                $parentYorum->yanit->prepend($eklenenYorum);
            }
        } else {
            // Ana yorum ekleniyorsa: Direkt ana yorumlar listenize ekleyin.
            $this->yorumlar->prepend($eklenenYorum);
        }
    }

    #[On('yorumSilindi')]
    public function yorumSilindi($silinenYorumId)
    {
        $silinenYorumId = decrypt($silinenYorumId);

        $this->yorumlar = $this->yorumlar->reject(function ($yorum) use ($silinenYorumId) {
            return $yorum['etkinlik_yorumlari_id'] === $silinenYorumId;
        });

        $this->totalYorum = EtkinlikYorum::where('etkinlikler_id', $this->etkinlikid)
            ->whereNull('yanitlanan_etkinlik_yorumlari_id')
            ->where('aktiflik', 1)
            ->where('yorum_tipi', $this->kamuYorumu)
            ->count();
    }
    #[On('toggleKamuYorumlari')]
    public function toggleKamuYorumlari() {
        $this->kamuYorumu = !$this->kamuYorumu;

        $this->mount($this->etkinlikid);
    }

    public function loadMore()
    {
        // Görüntüleme sınırını 10 artırıyoruz.
        $this->perPage += 10;

        // Yeni perPage değeriyle tüm yorumları yeniden sorguluyoruz.
        $this->yorumlar = EtkinlikYorum::withCount('begeni')
            ->where('etkinlikler_id', $this->etkinlikid)
            ->whereNull('yanitlanan_etkinlik_yorumlari_id')
            // Önce beğeni sayısı belirli eşik değer veya üstünde olanları getirir.
            ->orderByRaw("CASE WHEN begeni_count >= ? THEN 0 ELSE 1 END", [$this->threshold])
            // Ardından beğeni sayısına göre (yüksekten düşüğe) sıralar.
            // ->orderByDesc('begeni_count')
            // Son olarak, eklenme tarihine göre (en yeniler önce) sıralar.
            ->orderByDesc('created_at')
            ->where('aktiflik', 1)
            ->where('yorum_tipi', $this->kamuYorumu)
            ->take($this->perPage)
            ->get();
    }

    public function render()
    {
        return view('livewire.etkinlik-yorum-component');
    }
}
