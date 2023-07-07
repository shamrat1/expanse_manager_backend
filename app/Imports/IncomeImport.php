<?php

namespace App\Imports;

use App\Category;
use App\Income;
use App\User;
use DateTime;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IncomeImport implements ToModel,WithHeadingRow
{
   /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {


        if(gettype($row['date'])=="string"){
            $formatted_date =  session()->get('date');

        }
        else{
        // convert excel date to php date
        $excelDate = $row['date'];
        $miliseconds = ($excelDate - (25567 + 2)) * 86400 * 1000;
        $seconds = $miliseconds / 1000;
        $date = date("Y-m-d", $seconds);
        $d = new DateTime($date);
        $formatted_date = $d->format('Y-m-d');
        session()->put('date',$formatted_date);
        }
        if($row['amount']==null||$row['amount']==0||$row['amount']=='0.00')return;
        $category = Category::where([
            'type' => 'income',
            'name' => $row['category'],
        ])->first();
        if($category==null){
            $category = new Category();
            $category->name = $row['category'];
            $category->type ='income';
            $category->save();
            $cat_id =$category->id;
        }
        else{
            $cat_id = $category->id;
        }

        $user = User::where([
            'name' => $row['from'],
        ])->first();
        if($user==null){
            $user = new User();
            $user->name = $row['from']??"üsername";
            $user->email ='user@email.com';
            $user->password =Hash::make('password');
            $user->save();
            $user_id =$user->id;
        }
        else{
            $user_id = $user->id;
        }
        return new Income([
            'entry_date'=>$formatted_date,
            'amount'=>$row['amount'],
            'description'=>$row['reason'],
            'category_id'=>$cat_id,
            'created_by_id'=>$user_id,
        ]);
    }
}
