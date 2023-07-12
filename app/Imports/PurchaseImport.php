<?php

namespace App\Imports;
use App\Models\Supplier;
use App\Models\Purchase;
use DateTime;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PurchaseImport implements ToModel,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {

        if(gettype($row['date'])=="string"||$row['date']==null){
            $formatted_date =  session()->get('date1');

        }
        else{
        // convert excel date to php date
        $excelDate = $row['date'];
        $miliseconds = ($excelDate - (25567 + 2)) * 86400 * 1000;
        $seconds = $miliseconds / 1000;
        $date = date("Y-m-d", $seconds);
        $d = new DateTime($date);
        $formatted_date = $d->format('Y-m-d');
        session()->put('date1',$formatted_date);
        }
        $supplier = Supplier::where([
            'name' => $row['supplier'],
        ])->first();
        if($supplier==null){
            $supplier = new Supplier();
            $supplier->name = $row['supplier']??"supplier";
            $supplier->save();
            $supplier_id =$supplier->id;
        }
        else{
            $supplier_id = $supplier->id;
        }
        return new Purchase([
            'date'=>$formatted_date,
            'quantity'=>$row['quantity']??0,
            'rate'=>$row['rate']??0.00,
            'total_amount'=>$row['total_amount']??0.00,
            'discount'=>$row['discount']??0.00,
            'total_payment'=>$row['total_payable_amount']??0.00,
            'paid'=>$row['total_paid_amount']??0.00,
            'prev_due'=>$row['previous_due']??0.00,
            'due'=>$row['due']??0.00,
            'supplier_id'=>$supplier_id,
        ]);
    }
}
