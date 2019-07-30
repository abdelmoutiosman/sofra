<?php

namespace App\Http\Controllers\Api\Resturant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Client;
use Illuminate\Validation\Rule;

class MainController extends Controller
{
    public function getResturantClassification (Request $request){
        $user=auth('api_resturant')->user();
        $classifications=$user->classifications()->get();
        return responseJson(1, 'success', $classifications);  
    }
    public function contacts(Request $request){
        $validator=  validator()->make($request->all(),[
            'name'         => 'required',
            'email'        => 'required',
            'phone'        => 'required',
            'content'      => 'required',
            'type'     => 'required|in:complaint,suggestion,inquiry',
        ]);
        if($validator->fails()){
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $user=auth('api_resturant')->user()->contacts()->create($request->all());
        return responseJson(1, 'تم الاضافه بنجاح', $user);
    }
    public function addProduct(Request $request){
        $validator=  validator()->make($request->all(),[
            'name'         => 'required|unique:products,name',
            'description'  => 'required',
            'price'        => 'required|numeric',
            'preparing_time'=> 'required',
            'image'=> 'required|mimes:jpeg,jpg,png',
        ]);
        if($validator->fails()){
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $product=auth('api_resturant')->user()->products()->create($request->all());
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
        return responseJson(1, 'تم الاضافه بنجاح', [
            'product' => $product->load('resturant')
        ]);
    }
    public function updateProduct(Request $request){
        $product=auth('api_resturant')->user()->products()->find($request->product_id);
        $validator=  validator()->make($request->all(),[
            'name'         => 'required',Rule::unique('products', 'name')->ignore($product->id),
            'description'  => 'required',
            'price'        => 'required|numeric',
            'preparing_time'=> 'required',
            'image'=> 'required|mimes:jpeg,jpg,png',
        ]);
        if($validator->fails()){
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        if (!$product)
        {
            return responseJson(0,'لا يمكن الحصول على البيانات');
        }
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
        return responseJson(1, 'تم التعديل بنجاح', ['product'=>$product->load('resturant')]);
    }
    public function deleteProduct(Request $request)
    {
        $product=auth('api_resturant')->user()->products()->find($request->product_id);
        if (!$product)
        {
            return responseJson(0,'لا يمكن الحصول على البيانات');
        }
        if (count($product->orders) > 0)
        {
            $product->update(['disabled' => 1]);
            return responseJson(1,'تم الحذف بنجاح');
        }
        // if(file_exists($product->image))
        //     unlink($product->image);
        // $product->delete();
        return responseJson(1,'تم الحذف بنجاح');
    }
    public function addOffer(Request $request){
        $offer=auth('api_resturant')->user()->offers()->create($request->all());
        $validator=  validator()->make($request->all(),[
            'name'         => 'required',Rule::unique('offers', 'name')->ignore($offer->id),
            'description'  => 'required',
            'price'        => 'required|numeric',
            'image'=> 'required|mimes:jpeg,jpg,png',
            'starting_at' => 'required',
            'ending_at'   => 'required',
        ]);
        if($validator->fails()){
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        if($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path.'/images/offers/'; // upload path
            $logo = $request->file('image');
            $extension = $logo->getClientOriginalExtension(); // getting image extension
            $name = time().''. rand(11111, 99999).'.'.$extension; // renameing image
            $logo->move($destinationPath, $name); // uploading file to given path
            $offer->update(['image' => 'images/offers/'.$name]);
        }
        $offer->save();
        return responseJson(1, 'تم الاضافه بنجاح', [
            'offer' => $offer->load('resturant')
        ]);
    }
    public function updateOffer(Request $request){
        $validator=  validator()->make($request->all(),[
            'name'         => 'required|unique:offers,name',
            'description'  => 'required',
            'price'        => 'required|numeric',
            'image'=> 'required|mimes:jpeg,jpg,png',
            'starting_at' => 'required',
            'ending_at'   => 'required',
        ]);
        if($validator->fails()){
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $offer=auth('api_resturant')->user()->offers()->find($request->offer_id);
        if (!$offer)
        {
            return responseJson(0,'لا يمكن الحصول على البيانات');
        }
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
        return responseJson(1, 'تم التعديل بنجاح', ['offer'=>$offer->load('resturant')]);
    }
    public function deleteOffer(Request $request)
    {
        $offer=auth('api_resturant')->user()->offers()->find($request->offer_id);
        if (!$offer)
        {
            return responseJson(0,'لا يمكن الحصول على البيانات');
        }
        if(file_exists($offer->image))
            unlink($offer->image);
        $offer->delete();
        return responseJson(1,'تم الحذف بنجاح');
    }
    public function notificationCount(Request $request){
        $count=$request->user()->notifications()->where(function ($query) use ($request){
            $query->where('is_read',0);
        })->count();
        return responseJson(1, 'success', ['notification_count'=>$count]);
    }
    public function acceptOrder(Request $request){
        $order= $request->user()->orders()->find($request->order_id);
        if (!$order)
        {
            return responseJson(0,'لا يمكن الحصول على بيانات الطلب');
        }
        if ($order->state == 'accepted')
        {
            return responseJson(1,'تم قبول الطلب',$order);
        }
        $order->update(['state' => 'accepted']);
        $client=Client::find($order->client_id);
        //$client = $order->client;
        $notification=$client->notifications()->create([
            'title' => 'تم قبول طلبك',
            'body' => 'تم قبول الطلب رقم '.$request->order_id,
            'order_id' => $request->order_id,
        ]);
        $tokens = $client->tokens()->where('token','!=','')->pluck('token')->toArray();
        //fcm
        if (count($tokens)){
            $title = $notification->title;
            $body = $notification->body;
            $data =[
                'order_id' => $order->id,
                //'user_type' => 'client',
            ];
            $send = notifyByFirebase($title , $body , $tokens, $data);
            info("firebase result: " . $send);
            //  info("data: " . json_encode($data));
        }

        //one signal
//        $audience = ['include_player_ids' => $tokens];
//        $contents = [
//            'en' => 'Order no. '.$request->order_id.' is accepted',
//            'ar' => 'تم قبول الطلب رقم '.$request->order_id,
//        ];
//        $send = notifyByOneSignal($audience , $contents , [
//            'user_type' => 'client',
//            'action' => 'accept-order',
//            'order_id' => $request->order_id,
//            'restaurant_id' => $request->user()->id,
//        ]);
//        $send = json_decode($send);
        return responseJson(1,'تم قبول الطلب');
    }
    public function rejectOrder(Request $request){
        $order= $request->user()->orders()->find($request->order_id);
        if (!$order)
        {
            return responseJson(0,'لا يمكن الحصول على بيانات الطلب');
        }
        if ($order->state == 'rejected')
        {
            return responseJson(1,'تم رفض الطلب',$order);
        }
        $order->update(['state' => 'rejected']);
        $client=Client::find($order->client_id);
        //$client = $order->client;
        $notification=$client->notifications()->create([
            'title' => 'تم رفض طلبك',
            'body' => 'تم رفض الطلب رقم '.$request->order_id,
            'order_id' => $request->order_id,
        ]);
        $tokens = $client->tokens()->where('token','!=','')->pluck('token')->toArray();
        //fcm
        if (count($tokens)) {
            $title = $notification->title;
            $body = $notification->body;
            $data = [
                'order_id' => $order->id,
                //'user_type' => 'client',
            ];
            $send = notifyByFirebase($title, $body, $tokens, $data);
            info("firebase result: " . $send);
            //  info("data: " . json_encode($data));
        }

        //one signal
//        $audience = ['include_player_ids' => $tokens];
//        $contents = [
//            'en' => 'Order no. '.$request->order_id.' is rejected',
//            'ar' => 'تم رفض الطلب رقم '.$request->order_id,
//        ];
//        $send = notifyByOneSignal($audience , $contents , [
//            'user_type' => 'client',
//            'action' => 'reject-order',
//            'order_id' => $request->order_id,
//            'restaurant_id' => $request->user()->id,
//        ]);
//        $send = json_decode($send);
        return responseJson(1,'تم رفض الطلب');
    }
    public function confirmOrder(Request $request)

    {
        $order = $request->user()->orders()->find($request->order_id);
        if (!$order)
        {
            return responseJson(0,'لا يمكن الحصول على بيانات الطلب');
        }
        if ($order->state != 'accepted')
        {
            return responseJson(0,'لا يمكن تأكيد الطلب ، لم يتم قبول الطلب');
        }
        $order->update(['state' => 'delivered']);
        $client=Client::find($order->client_id);
        //$client = $order->client;
        $notification=$client->notifications()->create([
            'title' => 'تم تأكيد توصيل طلبك',
            'body' => 'تم تأكيد التوصيل للطلب رقم '.$request->order_id,
            'order_id' => $request->order_id,
        ]);
        $tokens = $client->tokens()->where('token','!=','')->pluck('token')->toArray();
        //fcm
        if (count($tokens)) {
            $title = $notification->title;
            $body = $notification->body;
            $data = [
                'order_id' => $order->id,
                //'user_type' => 'client',
            ];
            $send = notifyByFirebase($title, $body, $tokens, $data);
            info("firebase result: " . $send);
            //  info("data: " . json_encode($data));
        }
        //one signal
//        $audience = ['include_player_ids' => $tokens];
//        $contents = [
//            'en' => 'Order no. '.$request->order_id.' is delivered to you',
//            'ar' => 'تم تأكيد التوصيل للطلب رقم '.$request->order_id,
//        ];
//        $send = notifyByOneSignal($audience , $contents , [
//            'user_type' => 'client',
//            'action' => 'confirm-order-delivery',
//            'order_id' => $request->order_id,
//            'restaurant_id' => $request->user()->id,
//        ]);
//        $send = json_decode($send);
        return responseJson(1,'تم تأكيد الاستلام');
    }
    public function myOrders(Request $request){
        $orders = $request->user()->orders()->where(function($order) use($request){
            if ($request->has('state') && $request->state == 'completed')
            {
                $order->where('state' , '!=' , 'pending');
            }elseif ($request->has('state') && $request->state == 'current')
            {
                $order->where('state' , '=' , 'accepted');
            }elseif ($request->has('state') && $request->state == 'pending')
            {
                $order->where('state' , '=' , 'pending');
            }
            else {
                return responseJson(0,'no results found');
            }
        })->with('client','products','resturant.classifications','paymentmethod')->latest()->paginate(20);
        return responseJson(1,'تم التحميل',$orders);
    }
    public function listOrder(Request $request){
        $order= Order::with('client','paymentmethod','resturant.classifications','products')->find($request->order_id);
        $request->user()->notifications()->where('order_id',$request->order_id)->update(['is_read' => 1]);
        if(!$order){
            return responseJson(0,'no results found');
        }
        return responseJson(1,'success',$order);
    }
    public function listPayments(Request $request){
        $count = $request->user()->orders()->where('state','delivered')->count();
        $total_price = $request->user()->orders()->where('state','delivered')->sum('total_price');
        $commissions = $request->user()->orders()->where('state','delivered')->sum('commission');
        $payments = $request->user()->payments()->sum('amount');
        $net_commissions = $commissions - $payments;
        $commission = settings()->commission;
        return responseJson(1,'success',compact('count','total_price','commissions','payments','net_commissions','commission'));
    }
}
