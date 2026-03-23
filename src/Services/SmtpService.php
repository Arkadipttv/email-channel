<?php

namespace Arkadip\EmailChannel\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Arkadip\EmailChannel\Models\Message;
use Arkadip\EmailChannel\Models\MessageMeta;

class SmtpService
{
    public function sendEmail($to, $subject, $body)
    {
        Mail::raw($body, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });

        $message = Message::create([
            'channel_id' => config('email-channel.channel_id'),
            'integration_id' => config('email-channel.integration_id'),
            'message_id' => (string) Str::uuid(),
            'from' => config('mail.from.address'),
            'to' => $to,
            'content' => $body,
            'timestamp' => now(),
            'status' => 'sent'
        ]);

        MessageMeta::create([
            'ref_parent' => $message->id,
            'meta_key' => 'subject',
            'meta_value' => $subject,
        ]);
    }
}