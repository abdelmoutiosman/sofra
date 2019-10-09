<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Resturant;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $records=Offer::where(function($q) use($request) {
            if ($request->has('resturant_id')){
                $q->where('resturant_id',$request->resturant_id);
            }
        })->paginate(2);
        return view('offers.index',compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $resturants=Resturant::pluck('name','id')->toArray();
        return view('offers.create',compact('resturants'));
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
            'name'         => 'required|unique:offers,name',
            'description'  => 'required',
            'price'        => 'required|numeric',
            'image'=> 'required|mimes:jpeg,jpg,png',
            'starting_at' => 'required',
            'ending_at'   => 'required',
        ]);
        $offer=Offer::create($request->all());
        if($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path.'/images/offers/'; // upload path
            $logo = $request->file('image');
            $extension = $logo->getClientOriginalExtension(); // getting image extension
            $name = time().''. rand(11111, 99999).'.'.$extension; // renameing image
            $logo->move($destinationPath, $name); // uploading file to given path
            $product->update(['image' => 'images/offers/'.$name]);
        }
        $offer->save();
        flash()->success("Added Successfuly");
        return redirect(route('offer.index'));
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
        $model=Offer::findOrFail($id);
        return view('offers.edit',compact('model'));
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
        $offer=Offer::find($id);
        $this->validate($request, [
            'name'         => 'required',Rule::unique('offers', 'name')->ignore($offer->id),
            'image'=> 'required|mimes:jpeg,jpg,png',
        ]);
        $offer->update($request->except('image'));
        if($request->hasFile('image')) {
            if(file_exists($offer->image))
                unlink($offer->image);
            $path = public_path();
            $destinationPath = $path.'/images/offers/'; // upload path
            $logo = $request->file('image');
            $extension = $logo->getClientOriginalExtension(); // getting image extension
            $name = time().''.rand(11111, 99999).'.'.$extension; // renameing imag
            $logo->move($destinationPath, $name);// uploading file to given path
            $offer->image = 'images/offers/'.$name;
        }
        $offer->save();
        flash()->success("Edited Successfuly");
        return redirect(route('offer.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Offer::find($id);
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
