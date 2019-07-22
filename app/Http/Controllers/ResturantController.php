<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resturant;

class ResturantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $records=Resturant::where(function($q) use($request) {
            if ($request->has('name')){
                $q->where('name',$request->name);
            }
        })->get();
        return view('resturants.index',compact('records'));
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record=Resturant::with('classifications')->findOrFail($id);
        return view('resturants.show',compact('record'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Resturant::find($id);
        if (!$record) {
            return response()->json([
                'status'  => 0,
                'message' => 'تعذر الحصول على البيانات'
            ]);
        }
        $record->delete();
        return response()->json([
            'status'  => 1,
            'message' => 'تم الحذف بنجاح',
            'id'      => $id
        ]);
    }
    public function activated($id)
    {
        $resturant = Resturant::findOrFail($id);
        $resturant->activated = 1;
        $resturant->save();
        flash()->success('تم التفعيل');
        return back();
    }
    public function deactivated($id)
    {
        $resturant = Resturant::findOrFail($id);
        $resturant->activated = 0;
        $resturant->save();
        flash()->success('تم الإيقاف');
        return back();
    }
}
