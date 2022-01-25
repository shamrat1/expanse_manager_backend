<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\MultiTenantModelTrait;


class Todo extends Model
{
    use HasFactory, MultiTenantModelTrait;

    protected $fillable = [
        'category_id',
        'task',
        'note',
        'reminder_at',
        'created_by',
        'completed'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
