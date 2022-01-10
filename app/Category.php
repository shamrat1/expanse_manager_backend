<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\MultiTenantModelTrait;

class Category extends Model
{
    use SoftDeletes, MultiTenantModelTrait;

    public $table = 'categories';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'color',
        'type',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
    ];

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'category_id', 'id');
    }

    public function incomes()
    {
        return $this->hasMany(Income::class, 'income_category_id', 'id');
    }

    public function todos()
    {
        return $this->hasMany(Todo::class, 'category_id', 'id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
