<?php
namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\City;
use App\Models\Setting;
use App\Models\Contact;
use App\Models\Resturant;
use App\Models\Comment;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Offer;
use App\Models\Notification;

class MainController extends Controller
{
    public function regions(Request $request){
        $regions= Region::with('city')->where(function ($query) use($request){
            if($request->has('name')){
                $query->where('name',$request->name);
            }
        })->paginate(10);
        if($regions->count() < 1){
            return responseJson(0,'no results found');
        };
        return responseJson(1, 'success', $regions);
    }
    public function cities(Request $request){
        $cities= City::where(function ($query) use($request){
            if($request->has('name')){
                $query->where('name',$request->name);
            }
        })->get();
        if($cities->count() < 1){
            return responseJson(0,'no results found');
        }
        return responseJson(1, 'success', $cities);
    }
    public function settings(){
        $settings= Setting::all();
        return responseJson(1, 'success', $settings);
    }
    public function contacts(){
        $contacts= Contact::all();
        return responseJson(1, 'success', $contacts);
    }
    public function resturants(Request $request){
        $resturants= Resturant::with('classifications','city')->where(function ($query) use($request){
            if($request->has('name')){
                $query->where('name',$request->name);
            }
        })->paginate(10);
        if($resturants->count() < 1){
            return responseJson(0,'no results found');
        }
        return responseJson(1, 'success', $resturants);
    }
    public function comments(Request $request){
        $comments= Comment::with('client','resturant')->where(function ($query) use($request){
            if($request->has('resturant_id')){
                $query->where('resturant_id',$request->resturant_id);
            }
        })->paginate(10);
        if($comments->count() < 1){
            return responseJson(0,'no results found');
        }
        return responseJson(1, 'success', $comments);
    }
    public function paymentMethod(){
        $payments= PaymentMethod::all();
        return responseJson(1, 'success', $payments);
    }
    public function listProduct(Request $request)
    {
        $product = Product::with('resturant')->where(function ($query) use($request){
            if($request->has('resturant_id')){
                $query->where('resturant_id',$request->resturant_id);
            }
        })->paginate(10);
        if($product->count() < 1){
            return responseJson(0,'no results found');
        };
        return responseJson(1, 'success', $product);
    }
    public function listOffer(Request $request)
    {
        $offer = Offer::with('resturant')->where(function ($query) use($request){
            if($request->has('resturant_id')){
                $query->where('resturant_id',$request->resturant_id);
            }
        })->paginate(10);
        if($offer->count() < 1){
            return responseJson(0,'no results found');
        }
        return responseJson(1, 'success', $offer);
    }
    public function listNotifications()
    {
        $notification = Notification::all();
        if($notification->count() < 1){
            return responseJson(0,'no results found');
        };
        return responseJson(1, 'success', $notification);
    }
}
