<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Patient extends Model
{
    use HasUuids;

    protected $fillable = [
        'nik','name','dob','gender','address_detail','phone'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
}