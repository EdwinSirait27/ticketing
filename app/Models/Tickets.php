<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Tickets extends Model
{
    protected $table = 'ticket_tables';
    public $incrementing = false;
        protected $connection = 'mysql';

    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'request_uuid',
        'user_id',
        'queue_number',
        'title',
        'category',
        'description',
        'status',
         'attachment_folder',
    'attachment_url',
    ];
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id ??= (string) Str::uuid();
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany(Ticketattachments::class);
    }
}
