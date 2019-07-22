<?php
namespace App\Http\Controllers\Api\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetClient;
use Illuminate\Validation\Rule;
use App\Models\Token;
class AuthController extends Controller
{
    public function register(Request $request){
        $validator=  validator()->make($request->all(),[
            'name'         => 'required',
            'email'        => 'required|unique:clients,email',
            'phone'        => 'required',
            'city_id'      => 'required|exists:cities,id|numeric',
            'address'     => 'required',
            'password'     => 'required|confirmed',
            'image'        => 'required|mimes:jpeg,jpg,png',
        ]);
        if($validator->fails()){
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $request->merge(['password' => bcrypt($request->password)]);
        $client= Client::create($request->all());
        $client->api_token=  str_random(60);
        if($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path.'/images/clients/'; // upload path
            $logo = $request->file('image');
            $extension = $logo->getClientOriginalExtension(); // getting image extension
            $name = time().''.rand(11111, 99999).'.'.$extension; // renameing image 
            $logo->move($destinationPath,$name); // uploading file to given path
            $client->update(['image' => 'images/clients/'.$name]);
        }
        $client->save();
        return responseJson(1, 'تم الاضافه بنجاح', [
            'api_token' => $client->api_token,
            'client'    => $client]);
    }
    public function profile(Request $request){
        $user = $request->user();
        $validator=  validator()->make($request->all(),[
            'name'         => 'required',
            'email'        => 'required',Rule::unique('clients', 'email')->ignore($user->id),
            'phone'        => 'required',
            'city_id'      => 'required|exists:cities,id|numeric',
            'address'     => 'required',
            'password'     => 'required|confirmed',
            'image'        => 'required|mimes:jpeg,jpg,png',
        ]);
        if($validator->fails()){
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $request->merge(['password' => bcrypt($request->password)]);
        $user->update($request->except('image'));
        if($request->hasFile('image')) {
            if(file_exists($user->image))
                unlink($user->image);
            $path = public_path();
            $destinationPath = $path.'/images/clients/'; // upload path
            $logo = $request->file('image');
            $extension = $logo->getClientOriginalExtension(); // getting image extension
            $name = time().''.rand(11111, 99999).'.'.$extension; // renameing imag
            $logo->move($destinationPath, $name);// uploading file to given path
            $user->image = 'images/clients/'.$name;
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
        $client= Client::where('email',$request->email)->first();
        if($client){
            if(hash::check($request->password,$client->password)){
                return responseJson(1, 'تم تسجيل الدخول', [
                    'api_token'=> $client->api_token,
                    'client'   => $client
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
        $client = Client::where('email',$request->email)->first();
        if($client){
            $code = rand(1111,9999);
            $client->update(['pin_code' => $code]);
            Mail::to($client->email)
                ->send(new ResetClient($client));
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
        $client = Client::where('pin_code',$request->pin_code)->first();
        if($client)
        {
            $client->update(['pin_code' => null, 'password' => bcrypt($request->password)]);
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
        $user=auth('api_client')->user()->tokens()->create($request->all());
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
