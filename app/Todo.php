<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'todo_category_id',
        'task',
        'note',
        'reminder_at',
        'created_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function category()
    {
        return $this->belongsTo(TodoCategory::class, 'todo_category_id');
    }
}
