<?php

namespace App\Http\Controllers;

use App\Http\Requests\IletisimFormRequest;
use App\Models\IletisimForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;

class IletisimController extends Controller
{
    protected $request;
    protected $agent;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->agent = new Agent();
        $this->agent->setUserAgent($this->request->userAgent());
    }

    public function index()
    {
        return view('main.iletisim');
    }

    public function store(IletisimFormRequest $request)
    {
        try {
            // _token hariç tüm verileri al ve doğrulama işlemini uygula
            $validated = $request->validated();

            // Ek verileri ekle
            $validated['ip_address'] = $request->ip();
            $validated['user_agent'] = $request->userAgent();
            $validated['device'] = $this->agent->device();
            $validated['browser'] = $this->agent->browser();
            $validated['platform'] = $this->agent->platform();

            // İletişim formunu kaydet
            $form = IletisimForm::create($validated);

            // Birden fazla dosya yüklendiyse, her biri için işlemi yap
            if ($request->hasFile('dosyalar')) {
                foreach ($request->file('dosyalar') as $dosya) {
                    // Dosya adını benzersiz yapmak için time() kullanılıyor, gerekirse ek düzenleme yapabilirsiniz
                    $dosyaAdi = time() . '_' . $dosya->getClientOriginalName();
                    $dosyaYolu = uploadFile($dosya, 'iletisim_dosyalari');

                    // İlgili ilişki üzerinden dosyayı kaydediyoruz
                    $form->dosyalar()->create([
                        'dosya_adi' => $dosyaAdi,
                        'dosya_yolu' => $dosyaYolu,
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Mesajınız başarıyla gönderildi.');
        } catch (\Exception $e) {
            Log::error('Mesaj gönderilirken bir hata oluştu: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Mesaj gönderilirken bir hata oluştu.');
        }
    }
}
