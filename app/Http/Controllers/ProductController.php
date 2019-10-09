<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Resturant;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $records=Product::where(function($q) use($request) {
            if ($request->has('resturant_id')){
                $q->where('resturant_id',$request->resturant_id);
            }
        })->paginate(2);
        return view('products.index',compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $resturants=Resturant::pluck('name','id')->toArray();
        return view('products.create',compact('resturants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'         => 'required|unique:products,name',
            'description'  => 'required',
            'price'        => 'required',
            'preparing_time'=> 'required',
            'image'=> 'required|mimes:jpeg,jpg,png',
        ]);
        $product=Product::create($request->all());
        if($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path.'/images/products/'; // upload path
            $logo = $request->file('image');
            $extension = $logo->getClientOriginalExtension(); // getting image extension
            $name = time().''. rand(11111, 99999).'.'.$extension; // renameing image
            $logo->move($destinationPath, $name); // uploading file to given path
            $product->update(['image' => 'images/products/'.$name]);
        }
        $product->save();
        flash()->success("Added Successfuly");
        return redirect(route('product.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model=Product::findOrFail($id);
        return view('products.edit',compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product=Product::find($id);
        $this->validate($request, [
            'name'         => 'required',Rule::unique('products', 'name')->ignore($product->id),
            'image'=> 'required|mimes:jpeg,jpg,png',
        ]);
        $product->update($request->except('image'));
        if($request->hasFile('image')) {
            if(file_exists($product->image))
                unlink($product->image);
            $path = public_path();
            $destinationPath = $path.'/images/products/'; // upload path
            $logo = $request->file('image');
            $extension = $logo->getClientOriginalExtension(); // getting image extension
            $name = time().''.rand(11111, 99999).'.'.$extension; // renameing imag
            $logo->move($destinationPath, $name);// uploading file to given path
            $product->image = 'images/products/'.$name;
        }
        $product->save();
        flash()->success("Edited Successfuly");
        return redirect(route('product.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Product::find($id);
        if (!$record) {
            return response()->json([
                'status'  => 0,
                'message' => 'تعذر الحصول على البيانات'
            ]);
        }
        if(file_exists($record->image))
            unlink($record->image);
        $record->delete();
        return response()->json([
            'status'  => 1,
            'message' => 'تم الحذف بنجاح',
            'id'      => $id
        ]);
    }
}
