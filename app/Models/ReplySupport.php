<?php

namespace App\Models;

use App\Models\Traits\UuidTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplySupport extends Model
{
    use HasFactory, UuidTraits;

    public $incrementing = false;
    protected $keyType = 'uuid';
    protected $table = 'reply_support';


    protected $fillable = ['description', 'support_id', 'user_id'];

    public function support()
    {
        return $this->belongsTo(Support::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
