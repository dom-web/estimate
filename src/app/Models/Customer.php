<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','kana',
        'zip','address',
        'tel',
        'memo',
    ];

    public function estimates()
    {
        return $this->hasMany(Estimate::class);
    }
}
