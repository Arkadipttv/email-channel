<?php

namespace Arkadip\EmailChannel\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    public $timestamps = false;

    protected $fillable = [
        'channel_id',
        'integration_id',
        'message_id',
        'from',
        'to',
        'message_type',
        'content',
        'timestamp',
        'status',
        'raw_payload'
    ];
}