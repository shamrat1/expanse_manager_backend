<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['user_id','date','purchase_id','quantity','rate','total_amount','discount','total_payment','paid','due','prev_due'];
    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

}
