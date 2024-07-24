<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','category',
        'diff_low','diff_mid','diff_high',
        'acc_low','acc_mid','acc_high',
        'cost_low','cost_mid','cost_high',
        'risk_low','risk_mid','risk_high',
        'memo',
    ];
}
