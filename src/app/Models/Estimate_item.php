<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estimate_item extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'estimate_id','version','item_id',
        'diff','acc','cost','risk','effort',
    ];
    protected $primaryKey = null;
    public $incrementing = false;
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
