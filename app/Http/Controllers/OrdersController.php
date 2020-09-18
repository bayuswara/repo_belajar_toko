<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orders;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
  public function show(){
    $data_orders = Orders::join('customers', 'customers.id_customer', 'orders.id_order')->get();
    $data_orders = Orders::join('product', 'product.id_product', 'orders.id_product')->get();
    return Response()->json($data_orders);
  }
  public function detail($id_order){
    if(Orders::where('id_order', $id_order)->exists()){
      $data_orders = Orders::join('customers', 'customers.id_customer', 'orders.id_order')->where('order.id_order','=',$id_order)->get();
      $data_orders = Orders::join('product', 'product.id_product', 'orders.id_product')->where('orders.id_order', '=', $id_order)->get();
      return Response()->json($data_orders);
    }
    else{
      return Response()->json(['message' => 'Tidak ditemukan']);
    }
  }
    public function store(Request $request){
      $validator=Validator::make($request->all(),
      [
        'id_customer' => 'required',
        'id_product' => 'required',
        'tanggal_order' => 'required',
        'berat' => 'required',
        'total' => 'required'
      ]);
      if($validator->fails()){
        return Response()->json($validator->errors());
      }
      $simpan = Orders::create([
        'id_customer' => $request->id_customer,
        'id_product' => $request->id_product,
        'tanggal_order' => $request->tanggal_order,
        'berat' => $request->berat,
        'total' => $request->total
      ]);
      if($simpan){
        return Response()->json(['status' => 1]);
      }
      else{
        return Response()->json(['status' => 0]);
      }
    }
    public function update($id_order, Request $request){
    $validator=Validator::make($request->all(),[
      'id_customer' => 'required',
      'id_product' => 'required',
      'tanggal_order' => 'required',
      'berat' => 'required',
      'total' => 'required'
    ]);
    if($validator->fails()){
      return Response()->json($validator->errors());
    }
    $ubah = Orders::where('id_order', $id_order)->update([
      'id_customer' => $request->id_customer,
      'id_product' => $request->id_product,
      'tanggal_order' => $request->tanggal_order,
      'berat' => $request->berat,
      'total' => $request->total
    ]);
    if($ubah){
      return Response()->json(['status' => 1]);
    }
    else{
      return Response()->json(['status' => 0]);
    }
  }
  public function destroy($id_order){
    $hapus = Orders::where('id_order', $id_order)->delete();
    if($hapus){
      return Response()->json(['status' => 1]);
    }
    else{
      return Response()->json(['status' => 0]);
    }
  }
}