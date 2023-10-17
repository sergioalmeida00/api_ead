<?php

namespace App\Models;

use App\Models\Traits\UuidTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory, UuidTraits;

    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = ['name'];

    public function course()
    {
        $this->belongsTo(Course::class);
    }
}
