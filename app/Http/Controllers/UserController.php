<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        if(!auth()->user()->can('list users'))
//        {
//            abort(403);//هاجي على كل فانكشن واعمل كدا
//        }
        $records=User::paginate(2);
        return view('users.index',compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles=Role::pluck('name','id')->toArray();
        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|unique:users,name',
            'email'=>'required',
            'password'=>'required|confirmed',
            'roles_list'=>'required'
            ]);
        $request->merge(['password' => bcrypt($request->password)]);
        $user=User::create($request->except('roles_list'));
        $user->roles()->attach($request->input('roles_list'));
        flash()->success("Added Successfuly");
        return redirect(route('user.index'));

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
        $model= User::findOrFail($id);
        $roles=Role::pluck('name','id')->toArray();
        return view('users.edit',compact('model','roles'));
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
        $this->validate($request,[
            'name'=>'required|unique:users,name,'.$id,
            'email'=>'required',
            'roles_list'=>'required|array'
        ]);
        $user=User::findOrFail($id);
        $user->roles()->sync($request->input('roles_list'));
        $user->update($request->all());
        flash()->success("Edited Successfuly");
        return redirect(route('user.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = User::find($id);
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
    
    public function changePassword()
    {
        return view('users.reset-password');
    }
    public function changePasswordSave(Request $request)
    {
        $messages = [
            'old-password' => 'required',
            'password' => 'required|confirmed',
        ];
        $rules = [
            'old-password.required' => 'كلمة السر الحالية مطلوبة',
            'password.required' => 'كلمة السر مطلوبة',
        ];
        $this->validate($request,$messages,$rules);
        $user = Auth::user();
        if (Hash::check($request->input('old-password'), $user->password)) {
            // The passwords match...
            $user->password = bcrypt($request->input('password'));
            $user->save();
            flash()->success('Edited Password Successfully');
            return view('users.reset-password');
        }else{
            flash()->error('Password Dont match');
            return view('users.reset-password');
        }
    }
    public function forgetpassword()
    {
        return view('auth.passwords.reset');
    }
    public function passwordSave(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'email' => 'required',
            'password' => 'required|confirmed',
        ]);
        if ($validation->fails()) {
            return back()->with('errors', $validation->messages());
        }
        $admin = User::where('email', $request->email)->first();
        if ($admin) {
            $password = Hash::make($request->password);
            $admin->update(['password' => $password]);
            flash()->success("Password reset successfully you can login now");
            //return redirect('login');
            return redirect('forgetpassword');
        }
    }
}
