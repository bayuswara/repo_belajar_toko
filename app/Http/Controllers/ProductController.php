<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
  public function show(){
    $data_product = Product::join('orders', 'orders.id_order', 'product.id_order')->get();
    return Response()->json($data_product);
  }
  public function detail($id_product){
    if(Product::where('id_product', $id_product)->exists()){
      $data_product = Product::join('orders', 'orders.id_order', 'product.id_order')->where('product.id_product', '=', $id_product)->get();
      return Response()->json($data_product);
    }
    else{
      return Response()->json(['message' => 'Tidak ditemukan']);
    }
  }
  public function store(Request $request){
    $validator=Validator::make($request->all(),
    [
      'nama_product' => 'required',
      'id_order' => 'required'
    ]
  );
  if($validator->fails()){
    return Response()->json($validator->errors());
  }
  $simpan = Product::create([
    'nama_product' => $request->nama_product,
    'id_order' => $request->id_order
  ]);
  if($simpan){
    return Response()->json(['status'=>1]);
  }
  else{
    return Response()->json(['status'=>0]);
  }
  }
}