<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estimate_item extends Model
{
    use HasFactory;
    protected $fillable = [
        'estimate_id','version','item_id',
        'diff','acc','cost','risk',
    ];
    protected $primaryKey = null;
    public $incrementing = false;
}
