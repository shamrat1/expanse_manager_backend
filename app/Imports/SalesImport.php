<?php

namespace App\Imports;
use App\Models\Customers;
use App\Models\Sales;
use DateTime;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SalesImport implements ToModel,WithHeadingRow
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
        $customer = Customers::where([
            'name' => $row['customer'],
        ])->first();
        if($customer==null){
            $customer = new Customers();
            $customer->name = $row['customer']??"Customer";
            $customer->save();
            $customer_id =$customer->id;
        }
        else{
            $customer_id = $customer->id;
        }
        return new Sales([
            'date'=>$formatted_date,
            'quantity'=>$row['quantity']??0,
            'rate'=>$row['rate']??0.00,
            'total_amount'=>$row['total_amount']??0.00,
            'discount'=>$row['discount']??0.00,
            'total_payment'=>$row['total_payment']??0.00,
            'paid'=>$row['paid']??0.00,
            'due'=>$row['due']??0.00,
            'customer_id'=>$customer_id,
        ]);
    }
}
