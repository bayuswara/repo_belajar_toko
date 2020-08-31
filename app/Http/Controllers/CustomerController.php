<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customers;
use Illuminate\Support\Facades\Validator;

class CustomersController extends Controller
{
  public function show()
  {
    return Customers::all();
  }
    public function store(Request $request){
      $validator=Validator::make($request->all(),
      [
        'nama_customer' => 'required',
        'alamat' => 'required'
      ]
    );
    if($validator->fails()){
      return Response()->json($validator->errors());
    }
    $simpan = Customers::create([
      'nama_customer' => $request->nama_customer,
      'alamat' => $request->alamat
    ]);
    if($simpan){
      return Response()->json(['status'=>1]);
    }
    else{
      return Response()->json(['status'=>0]);
    }
    }
}