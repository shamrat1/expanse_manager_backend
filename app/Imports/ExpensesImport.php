<?php

namespace App\Imports;

use App\Expense;
use Carbon\Carbon;
use DateTime;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExpensesImport implements ToModel,WithHeadingRow
{
   /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // $excelDate = $row['date'];
        // $miliseconds = ($excelDate - (25567 + 2)) * 86400 * 1000;
        // $seconds = $miliseconds / 1000;
        // $date = date("Y-m-d", $seconds);
        // $d = new DateTime($date);
        // $formatted_date = $d->format('Y-m-d');
        return new Expense([
            'entry_date'=>"2023-03-30",
            'amount'=>$row['total_amount'],
            'description'=>$row['expense_details'],
            'category_id'=>1,
            'created_by_id'=>1,
        ]);
    }
}
