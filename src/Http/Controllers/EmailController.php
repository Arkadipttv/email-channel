<?php

namespace Arkadip\EmailChannel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Arkadip\EmailChannel\Services\ImapService;
use Arkadip\EmailChannel\Services\SmtpService;
use Arkadip\EmailChannel\Models\Message;

class EmailController extends Controller
{
    public function index()
    {
        return Message::latest('id')->limit(20)->get();
    }

    public function send(Request $request, SmtpService $smtp)
    {
        $request->validate([
            'to' => 'required|email',
            'subject' => 'required',
            'body' => 'required',
        ]);

        $smtp->sendEmail($request->to, $request->subject, $request->body);

        return ['message' => 'Email sent'];
    }
}