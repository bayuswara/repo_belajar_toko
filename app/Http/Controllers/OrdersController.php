<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orders;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
  public function show(){
    $data_orders = Orders::join('customers', 'customers.id_customer', 'orders.id_customer')->get();
    return Response()->json($data_orders);
  }
  public function detail($id_order){
    if(Orders::where('id_order', $id_order)->exists()){
    $data_orders = Orders::join('customers', 'customers.id_customer', 'orders.id_customer')->where('orders.id_order', '=', $id_order)->get();
    return Response()->json($data_orders);
  }
  else{
    return Response()->json(['message' => 'Tidak ditemukan']);
  }
}
  public function store(Request $request){
    $validator=Validator::make($request->all(),
    [
      'nama_order' => 'required',
      'tanggal_order' => 'required',
      'alamat_order' => 'required',
      'id_customer' => 'required'
    ]
  );
  if($validator->fails()){
    return Response()->json($validator->errors());
  }
  $simpan = Orders::create([
    'nama_order' => $request->nama_order,
    'tanggal_order' => $request->tanggal_order,
    'alamat_order' => $request->alamat_order,
    'id_customer' => $request->id_customer
  ]);
  if($simpan){
    return Response()->json(['status'=>1]);
  }
  else{
    return Response()->json(['status'=>0]);
  }
  }
}