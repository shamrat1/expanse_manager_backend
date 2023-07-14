<?php

namespace App\Imports;
use App\Models\Employee;
use App\Models\Payroll;
use DateTime;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PayrollsImport implements ToModel,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {

        $month =  session()->get('month');
        $employee = Employee::where([
            'name' => $row['employee_name'],
        ])->first();
        if($employee==null){
            $employee = new Employee();
            $employee->name = $row['employee_name']??"Employee";
            $employee->save();
            $employee_id =$employee->id;
        }
        else{
            $employee_id = $employee->id;
        }
        return new Payroll([
            'month'=>$month,
            'pay'=>$row['pay']??0.00,
            'total_worked_days'=>$row['total_days_worked']??0,
            'overtime_rate'=>$row['overtime']??0.00,
            'total_overtime_days'=>$row['total_overtime_days']??0,
            'overtime_pay'=>$row['total_overtime_pay']??0.00,
            'gross_pay'=>$row['gross_pay']??0.00,
            'deductibles'=>$row['other_deductibles']??0.00,
            'net_pay'=>$row['net_pay']??0.00,
            'paid'=>$row['paid']??0.00,
            'due'=>$row['due']??0.00,
            'employee_id'=>$employee_id,
        ]);
    }
}
