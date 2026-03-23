<?php

namespace Arkadip\EmailChannel\Models;

use Illuminate\Database\Eloquent\Model;

class MessageMeta extends Model
{
    protected $table = 'message_metas';
    public $timestamps = false;

    protected $fillable = [
        'ref_parent',
        'meta_key',
        'meta_value'
    ];
}