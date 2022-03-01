<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Expense;
use App\Income;

class TransactionController extends Controller
{
    public function index($type = "expense")
    {
        $transactions;
        if($type == "expense"){
            $transactions = Expense::where("created_by_id",auth()->id())->latest()->paginate(20);
        }else{
            $transactions = Income::where("created_by_id",auth()->id())->latest()->paginate(20);
        }
        $transactions->type = $type;

        return response()->json($transactions);
    }
}
