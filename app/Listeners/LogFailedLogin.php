<?php

namespace App\Listeners;

use App\Models\Kullanici;
use Illuminate\Auth\Events\Failed;
use Illuminate\Http\Request;
use App\Models\LoginHistory;
use Jenssegers\Agent\Agent;

class LogFailedLogin
{
    protected $request;
    protected $agent; // Agent nesnesini saklamak için

    /**
     * Create the event listener.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->agent = new Agent();
        $this->agent->setUserAgent($this->request->userAgent());
    }

    /**
     * Handle the event.
     */
    public function handle(Failed $event): void
    {
        // Başarısız giriş denemesi için kullanıcı bilgisi olmayabilir
        $credentials = $event->credentials;
        $credentials['email'] = $credentials['email'] ?? null;
        $kullanici_id = null;

        if ($credentials['email']) {
            $kullanici = Kullanici::where('email', $credentials['email'])->first();
            $kullanici_id = $kullanici->kullanicilar_id ?? null;
        }

        LoginHistory::create([
            'kullanicilar_id' => $kullanici_id,
            'login_at'        => now(),
            'ip_address'      => $this->request->ip(),
            'user_agent'      => $this->request->userAgent(),
            'device'          => $this->agent->device(),
            'browser'         => $this->agent->browser(),
            'platform'        => $this->agent->platform(),
            'successful'      => false,
            // Kullanıcı adı veya email gibi kimlik bilgilerini kaydetmek isteyebilirsiniz
        ]);
    }
}
