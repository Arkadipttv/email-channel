<?php

namespace Arkadip\EmailChannel\Services;

use Webklex\PHPIMAP\ClientManager;
use Arkadip\EmailChannel\Models\Message;
use Arkadip\EmailChannel\Models\MessageMeta;

class ImapService
{
    public function fetchEmails()
    {
        $config = config('email-channel.imap');

        $cm = new ClientManager([
            'default' => [
                'host' => $config['host'],
                'port' => $config['port'],
                'encryption' => $config['encryption'],
                'username' => $config['username'],
                'password' => $config['password'],
                'protocol' => 'imap'
            ]
        ]);

        $client = $cm->account('default');
        $client->connect();

        $messages = $client->getFolder('INBOX')->query()->all()->get();

        foreach ($messages as $msg) {

            $uid = $msg->getUid();

            if (Message::where('message_id', $uid)->exists()) continue;

            $message = Message::create([
                'channel_id' => config('email-channel.channel_id'),
                'integration_id' => config('email-channel.integration_id'),
                'message_id' => $uid,
                'from' => optional($msg->getFrom()->first())->mail ?? '',
                'to' => optional($msg->getTo()->first())->mail ?? '',
                'content' => $msg->getTextBody() ?: $msg->getHTMLBody(),
                'timestamp' => $msg->getDate()?->toDateTimeString(),
                'status' => 'received'
            ]);

            MessageMeta::create([
                'ref_parent' => $message->id,
                'meta_key' => 'subject',
                'meta_value' => $msg->getSubject(),
            ]);
        }
    }
}