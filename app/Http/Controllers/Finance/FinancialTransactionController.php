<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FinancialAccount;
use App\Models\FinancialTransation;
use App\Models\TypeMovements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FinancialTransactionController extends Controller
{
    //
    public function add(){
        $user = Auth::user();
        $categories = Category::where('user', $user->id)->get();
        $type = TypeMovements::all();
        $account = FinancialAccount::where('user', $user->id)->get();

        return view('app.adicionar', [
            'categorias' => $categories,
            'tipos' => $type,
            'contas' => $account
        ]);
    }

    public function store(Request $request){
        $transaction = New FinancialTransation();

        $transaction->name = $request->name;
        $transaction->type_movement = $request->type;
        $transaction->financial_account = $request->account;
        $transaction->category = $request->category;
        $transaction->value = $request->valueTransaction;
        $transaction->date = $request->dueDate;
        $transaction->description = $request->description;
        $transaction->user = Auth::user()->id;
        $transaction->state = empty($request->state);

        $transaction->save();

        return redirect()->route('listar');



    }

    public function list(){
        return view('app.consultar');
    }

    public function report(){
        return view('app.relatorios');

    }

}
