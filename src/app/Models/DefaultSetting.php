<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'diff_low', 'diff_mid', 'diff_high',
        'acc_low', 'acc_mid', 'acc_high',
        'cost_low', 'cost_mid', 'cost_high',
        'risk_low', 'risk_mid', 'risk_high',
    ];
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
}
