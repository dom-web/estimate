<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estimate extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','customer_id','person',
        'issue_date','limit_date',
        'memo',
        'user_id',
    ];
}
