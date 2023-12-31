<?php

namespace App\Models;

use App\Models\Traits\UuidTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory, UuidTraits;

    public $incrementing = false;
    protected $keyType = 'uuid';


    protected $fillable = ['name', 'description', 'image'];

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function certificate()
    {
        return $this->hasMany(Certificate::class);
    }
}
