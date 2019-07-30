<?php

namespace App\Http\Controllers\Api\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Resturant;
use App\Models\Order;
use App\Models\Product;

class MainController extends Controller
{
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
        $user=auth('api_client')->user()->contacts()->create($request->all());
        return responseJson(1, 'تم الاضافه بنجاح', $user);
    }
    public function addComment(Request $request){
        $validator=  validator()->make($request->all(),[
            'rating'         => 'in:1,2,3,4,5',
            'comment'        => 'required',
            'resturant_id'   => 'required|exists:resturants,id',
        ]);
        if($validator->fails()){
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $user=auth('api_client')->user()->comments()->create($request->all());
        return responseJson(1, 'تم التقييم بنجاح', $user);
    }
    public function notificationCount(Request $request){
        $count=$request->user()->notifications()->where(function ($query) use ($request){
            $query->where('is_read',0);
        })->count();
        return responseJson(1, 'success', ['notification_count'=>$count]);
    }
    public  function newOrder(Request $request){
        $validator = validator()->make($request->all(), [
            'resturant_id'     => 'required|exists:resturants,id',
            'notes'             => 'required',
            'address'           => 'required',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'products.*.product_id' => 'required|exists:products,id',//.* is array
            'products.*.quantity'=>'required',
            'products.*.special_order'=>'required',
        ]);
        if($validator->fails()){
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $resturant = Resturant::find($request->resturant_id);
        if ($resturant->availability == 'closed') {
            return responseJson(0, 'عذرا المطعم غير متاح في الوقت الحالي');
        }
        $order = $request->user()->orders()->create([
            'resturant_id'      => $request->resturant_id,
            'notes'             => $request->notes,
            'state'             => 'pending', // db default
            'address'           => $request->address,
            'payment_method_id' => $request->payment_method_id,
        ]);
        $cost = 0;
        $delivery_cost = $resturant->delivery_cost;
        if ($request->has('products')) {
            foreach ($request->products as $productId) {
                $product = Product::find($productId['product_id']);
                if ($product->disabled == 1) {
                    return responseJson(0, 'عذرا المنتج غير متاح في الوقت الحالي');
                }
                $readyproduct = [
                    $productId['product_id'] => [
                        'quantity' => $productId['quantity'],
                        'price' => $product->price,
                        'special_order' => (isset($productId['special_order'])) ? $productId['special_order'] : ''
                    ]
                ];
                $order->products()->attach($readyproduct);
                $cost += ($product->price * $productId['quantity']);
            }
        }
        if ($cost >= $resturant->minimum_order){
            $total = $cost + $delivery_cost;
            $commission = settings()->commission * $cost;
            $net = $total - settings()->commission;
//            $order->update([
//                'cost'          => $cost,
//                'delivery_cost' => $delivery_cost,
//                'total_price'   => $total,
//                'commission'    => $commission,
//                'net'           => $net,
//            ]);
            $order->cost=$cost;
            $order->delivery_cost=$delivery_cost;
            $order->total_price=$total;
            $order->commission=$commission;
            $order->net=$net;
            $order->save();
            $notification = $resturant->notifications()->create([
                'title'   =>'لديك طلب جديد',
                'body'    =>$request->user()->name .  'لديك طلب جديد من العميل ',
                'order_id'=>$order->id,
            ]);
            $tokens = $resturant->tokens()->where('token', '!=' ,'')->pluck('token')->toArray();
            //fcm(firebaseCloudMessage)
            if (count($tokens)) {
                $title= $notification->title;
                $body = $notification->body;
                $data = [
                    'order_id' => $order->id,
                    //'user_type' => 'restaurant',
                ];
                $send = notifyByFirebase($title, $body, $tokens, $data);
                info("firebase result: " . $send);
                //  info("data: " . json_encode($data));
            }
                //one signal
//                $audience = ['include_player_ids' => $tokens];
//                $contents = [
//                    'en' => 'You have New order by client ' . $request->user()->name,
//                    'ar' => 'لديك طلب جديد من العميل ' . $request->user()->name,
//                ];
//                $send = notifyByOneSignal($audience, $contents, [
//                    //'user_type' => 'restaurant',
//                    //'action'    => 'new-order',
//                    'order_id'  => $order->id,
//                ]);
//                $send = json_decode($send);
//                /* notification */
//                $data = [
//                    'order' => $order->load('items')
//                ];

            return responseJson(1,'تم الطلب بنجاح',[
                'order' => $order->fresh()->load('client','resturant.classifications','products'),
            ]);
        }
        else{
            $order->products()->delete();
            $order->delete();
            return responseJson(0, 'الطلب لابد ان لا يكون اقل من'.$resturant->minimum_order.'ريال');
        }
    }
    public function confirmOrder(Request $request)
    {
        $order = $request->user()->orders()->find($request->order_id);
        if (!$order) {
            return responseJson(0, 'لا يمكن الحصول على البيانات');
        }
        if ($order->state != 'accepted') {
            return responseJson(0, 'لا يمكن تأكيد استلام الطلب ، لم يتم قبول الطلب');
        }
        $order->update(['state' => 'delivered']);
        $resturant= Resturant::find($order->resturant_id);
        //$resturant = $order->resturant;
        $notification=$resturant->notifications()->create([
            'title'      => 'تم تأكيد توصيل طلبك من العميل',
            'body'    => 'تم تأكيد التوصيل للطلب رقم ' . $request->order_id . ' للعميل',
            'order_id'   => $request->order_id,
        ]);
        $tokens = $resturant->tokens()->where('token', '!=', '')->pluck('token')->toArray();
        //fcm
        if (count($tokens)){
            $title = $notification->title;
            $body = $notification->body;
            $data =[
                'order_id' => $order->id,
                //'user_type' => 'client',
            ];
            $send = notifyByFirebase($title , $body, $tokens, $data);
            info("firebase result: " . $send);
            //  info("data: " . json_encode($data));
        }
        //one signal
//        $audience = ['include_player_ids' => $tokens];
//        $contents = [
//            'en' => 'Order no. ' . $request->order_id . ' is delivered to client',
//            'ar' => 'تم تأكيد التوصيل للطلب رقم ' . $request->order_id . ' للعميل',
//        ];
//        $send = notifyByOneSignal($audience, $contents, [
//            'user_type' => 'restaurant',
//            'action'    => 'confirm-order-delivery',
//            'order_id'  => $request->order_id,
//        ]);
//        $send = json_decode($send);
        return responseJson(1, 'تم تأكيد الاستلام');
    }
    public function declineOrder(Request $request)
    {
        $order = $request->user()->orders()->find($request->order_id);
        if (!$order) {
            return responseJson(0, 'لا يمكن الحصول على البيانات');
        }
        if ($order->state != 'accepted') {
            return responseJson(0, 'لا يمكن رفض استلام الطلب ، لم يتم قبول الطلب');
        }
        $order->update(['state' => 'decliened']);
        $resturant= Resturant::find($order->resturant_id);
        //$resturant = $order->resturant;
        $notification=$resturant->notifications()->create([
            'title'      => 'تم رفض توصيل طلبك من العميل',
            'body'    => 'تم رفض التوصيل للطلب رقم ' . $request->order_id . ' للعميل',
            'order_id'   => $request->order_id,
        ]);
        $tokens = $resturant->tokens()->where('token', '!=', '')->pluck('token')->toArray();
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
//            'en' => 'Delivery if order no. ' . $request->order_id . ' is declined by client',
//            'ar' => 'تم رفض التوصيل للطلب رقم ' . $request->order_id . ' للعميل',
//        ];
//        $send = notifyByOneSignal($audience, $contents, [
//            'user_type' => 'restaurant',
//            'action'    => 'decline-order-delivery',
//            'order_id'  => $request->order_id,
//        ]);
//        $send = json_decode($send);
        return responseJson(1, 'تم رفض استلام الطلب');
    }
    public function myOrders(Request $request){
        $orders = $request->user()->orders()->where(function ($order) use ($request) {
            if ($request->has('state') && $request->state == 'completed') {
                $order->where('state', '!=', 'pending');
            } elseif ($request->has('state') && $request->state == 'pending') {
                $order->where('state', '=', 'pending');
            }
        })->with('products','resturant.classifications','client','paymentmethod')->latest()->paginate(20);
        return responseJson(1, 'تم التحميل', $orders);
    }
    public function listOrder(Request $request){
        $order= Order::with('client','paymentmethod','resturant.classifications','products')->find($request->order_id);
        $request->user()->notifications()->where('order_id',$request->order_id)->update(['is_read' => 1]);
        if(!$order){
            return responseJson(0,'no results found');
        }
        return responseJson(1,'success',$order);
    }
}
