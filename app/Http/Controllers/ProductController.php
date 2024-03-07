<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\product;
use App\Models\section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products= product::all();
        $sections = section::all();
        return view('products.products',[
          'products'=>$products,
          'sections'=>$sections,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name'=>['required','unique:products,name']
        ],[
            'name.unique'=>"هذا الاسم موجود مسبقا"
        ]);
        $request->merge([
            'user_id' => Auth::user()->id,

        ]);
           product::create($request->all());
           return redirect(route('products.index'))->with('success','تم اضافة منتج بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        //
        $product = product::findorfail($id);
        $invoice=invoices::all()->where('product',$product->name);
        $sections=section::all();
        return view('products.show',[
            'product' => $product,
            'sections'=> $sections,
            'invoice'=> $invoice
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $id = $request->id;
        $request->validate([
            'name' => ['required', "unique:products,name,$id"]
        ], [
            'name.unique' => "هذا الاسم موجود مسبقا"
        ]);
        $product = product::findorfail($id);
        $product->update($request->all());
        return redirect(route('products.index'))->with('success','تم تحديث المنتج بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->id;
        $product = product::findorfail($id);
        $product->delete();
        return redirect(route('products.index'))->with('success','تم حذف المنتج بنجاح');
    }
}
