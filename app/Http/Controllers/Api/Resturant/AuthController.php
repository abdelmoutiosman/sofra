<?php

namespace App\Http\Controllers\Api\Resturant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Resturant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetResturant;
use Illuminate\Validation\Rule;
use App\Models\Token;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator=  validator()->make($request->all(),[
            'name'         => 'required',
            'city_id'      => 'required|exists:cities,id',
            'email'        => 'required|unique:resturants,email',
            'password'     => 'required|confirmed',
            'classification.*' => 'required|exists:classifications,id',
            'minimum_order'=> 'required',
            'delivery_cost'=> 'required',
            'phone'        => 'required',
            'whattsapp'     => 'required',
            'image'        => 'required|mimes:jpeg,jpg,png',
            'availability' => 'required|in:closed,opened',
        ]);
        if($validator->fails()){
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $request->merge(['password' => bcrypt($request->password)]);
        $resturant= Resturant::create($request->all());
        if($request->has('classifications'))
        {
            $resturant->classifications()->sync($request->classifications);
        }
        $resturant->api_token=  str_random(60);
        if($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path.'/images/resturants/'; // upload path
            $logo = $request->file('image');
            $extension = $logo->getClientOriginalExtension(); // getting image extension
            $name = time().''. rand(11111, 99999).'.'.$extension; // renameing image
            $logo->move($destinationPath, $name); // uploading file to given path
            $resturant->update(['image' => 'images/resturants/'.$name]);  
        }
        $resturant->save();
        return responseJson(1, 'تم الاضافه بنجاح', [
            'api_token' => $resturant->api_token,
            'resturant'    => $resturant->load('classifications')
        ]);
    }
    public function profile(Request $request){
        $user=$request->user();
        $validator=  validator()->make($request->all(),[
            'name'         => 'required',
            'city_id'      => 'required|exists:cities,id',
            'email'        => 'required',Rule::unique('resturants', 'email')->ignore($user->id),
            'password'     => 'required|confirmed',
            'classifications.*'=> 'required|exists:classifications,id',
            'minimum_order'=> 'required',
            'delivery_cost'=> 'required',
            'phone'        => 'required',
            'whattsapp'     => 'required',
            'image'        => 'required|mimes:jpeg,jpg,png',
            'availability' => 'required|in:closed,opened',
        ]);
        if($validator->fails()){
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $request->merge(['password' => bcrypt($request->password)]);
        $user->update($request->except('image'));
        if($request->has('classifications'))
        {
            $user->classifications()->sync($request->classifications);
        }
        if($request->hasFile('image')) {
            if(file_exists($user->image))
                unlink($user->image);
            $path = public_path();
            $destinationPath = $path.'/images/resturants/'; // upload path
            $logo = $request->file('image');
            $extension = $logo->getClientOriginalExtension(); // getting image extension
            $name = time().''.rand(11111, 99999).'.'.$extension; // renameing image
            $logo->move($destinationPath, $name); // uploading file to given path
            $user->image='images/resturants/'.$name; 
        }
        $user->save();
        return responseJson(1, 'تم التعديل بنجاح', $user);
    }
    public function login(Request $request){
        $validator=  validator()->make($request->all(),[
            'email'    => 'required',
            'password' => 'required'
        ]);
        if($validator->fails()){
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $resturant= Resturant::where('email',$request->email)->first();
        if($resturant){
            if(hash::check($request->password,$resturant->password)){
                return responseJson(1, 'تم تسجيل الدخول', [
                    'api_token'=> $resturant->api_token,
                    'resturant'   => $resturant->load('classifications')
                ]);
            }
            else {
                return responseJson(0,'بيانات الدخول غير صحيحه');
            }
        }
        else {
            return responseJson(0,'بيانات الدخول غير صحيحه');
        }
    }
    public function resetPassword(Request $request){
        $validator=  validator()->make($request->all(),[
            'email'  => 'required'
        ]);
        if($validator->fails()){
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $resturant = Resturant::where('email',$request->email)->first();
        if($resturant){
            $code = rand(1111,9999);
            $resturant->update(['pin_code' => $code]);
            Mail::to($resturant->email)
                ->send(new ResetResturant($resturant));
            return responseJson(1, 'برجاء فحص الايميل');
        }
        else{
            return responseJson(0,'الايميل غير صحيح');
        }
    }
    public function newPassword(Request $request){
        $validator=  validator()->make($request->all(),[
            'pin_code' => 'required|min:4',
            'password' => 'required|confirmed',
        ]);
        if($validator->fails()){
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $resturant = Resturant::where('pin_code',$request->pin_code)->first();
        if($resturant)
        {
            $resturant->update(['pin_code' => null, 'password' => bcrypt($request->password)]);
            return responseJson(1,'تم تغيير كلمة المرور بنجاح');
        }
        else{
            return responseJson(0,'هذا الكود غير صالح');
        }
    }
    public function registerToken(Request $request){
        $validator=  validator()->make($request->all(),[
            'token' => 'required',
            'type'  => 'required|in:android,ios'
        ]);
        if($validator->fails()){
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        Token::where('token',$request->token)->delete();
        $user=auth('api_resturant')->user()->tokens()->create($request->all());
        return responseJson(1,'تم التسجيل بنجاح',$user);
    }
    public function removeToken(Request $request){
        $validator=  validator()->make($request->all(),[
            'token' => 'required',
        ]);
        if($validator->fails()){
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        Token::where('token',$request->token)->delete();
        return responseJson(1,'تم الحذف بنجاح');
    }
}
