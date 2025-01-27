<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use App\Mail\OrnekMail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendMail()
    {
        Mail::to('vgunduz@nku.edu.tr')->send(new OrnekMail());

        return 'Mail gönderildi.';
    }
}
