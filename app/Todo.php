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
        'created_by_id',
        'completed'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'created_by_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
