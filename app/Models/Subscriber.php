<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{

    protected $fillable = [
        'name', 'msisdn', 'third_party_conversation_id', 'transaction_reference'
    ];

    protected $hidden = [
        '',
    ];
}
