<?php

namespace App\Listeners;

use App\Models\LoginHistory;
use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class LogLoginHistory
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
    public function handle(Login $event): void
    {
        $kullanici = $event->user;

        $lastLogin = $kullanici->loginHistories->last();

        if (!$kullanici->loginHistories->count()) {
            $kullanici->toplamPuanEkle(100);
        }

        if ($lastLogin && $lastLogin->login_at->isBefore(Carbon::today())) {
            $kullanici->puanKullan(5);
        }

        LoginHistory::create([
            'kullanicilar_id' => $kullanici->kullanicilar_id,
            'login_at'        => now(),
            'ip_address'      => $this->request->ip(),
            'user_agent'      => $this->request->userAgent(),
            'device'          => $this->agent->device(),
            'browser'         => $this->agent->browser(),
            'platform'        => $this->agent->platform(),
            // 'country' ve 'city' gibi alanları eklemek için GeoIP kullanabilirsiniz
            'successful'      => true,
        ]);
    }
}
