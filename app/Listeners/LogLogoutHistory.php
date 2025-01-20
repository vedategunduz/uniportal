<?php

namespace App\Listeners;

use App\Models\LoginHistory;
use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;

class LogLogoutHistory
{
    protected $request;
    /**
     * Create the event listener.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     */
    public function handle(Logout $event): void
    {
        $kullanici = $event->user;

        // Kullanıcının en son giriş kaydını alalım
        $latestLogin = LoginHistory::where('kullanicilar_id', $kullanici->kullanicilar_id)
            ->whereNull('logout_at')
            ->latest('login_at')
            ->first();

        if ($latestLogin) {
            $latestLogin->update([
                'logout_at' => now(),
            ]);
        }
    }
}
