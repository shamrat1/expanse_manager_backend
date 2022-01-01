<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','color','created_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }
}
