<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payroll extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        "month",
        "pay",
        "total_worked_days",
        "overtime_rate",
        "total_overtime_days",
        "overtime_pay",
        "gross_pay",
        "deductibles",
        "net_pay",
        "paid",
        "due",
        "employee_id",
    ];
    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
