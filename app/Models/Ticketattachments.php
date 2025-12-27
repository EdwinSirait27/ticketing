<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ticketattachments extends Model
{
     protected $table = 'ticket_attachment';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'ticket_id',
        'file_name',
        'file_path',
    ];
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id ??= (string) Str::uuid();
        });
    }
}
