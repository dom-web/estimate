<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Estimate extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name','customer_id','person',
        'issue_date','limit_date',
        'memo',
        'user_id',
        'issued','ordered','on_hold'
    ];

    protected $casts = [
        'limit_date' => 'datetime',
        'issued'=>'boolean',
        'ordered'=>'boolean',
        'on_hold'=>'boolean',
    ];

    // Customerとのリレーション
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Itemsとのリレーション
    public function items()
    {
        return $this->hasMany(Estimate_item::class);
    }
}

