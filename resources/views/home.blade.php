@extends('layouts.app')
@inject('client', 'App\Models\Client')
@inject('resturant', 'App\Models\Resturant')
@inject('order', 'App\Models\Order')
@inject('comment', 'App\Models\Comment')
@inject('classification', 'App\Models\Classification')
@inject('offer', 'App\Models\Offer')
@inject('product', 'App\Models\Product')
@inject('city', 'App\Models\City')
@inject('region', 'App\Models\Region')
@inject('paymentmethod', 'App\Models\PaymentMethod')
@inject('contact', 'App\Models\Contact')
@inject('setting', 'App\Models\Setting')
@inject('payment', 'App\Models\Payment')
@section('content')
@section('page_title')
    Dashboard
@endsection
@section('small_title')
    Control Panel
@endsection
<section class="content">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">clients</span>
                <span class="info-box-number">{{$client->count()}}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">resturants</span>
                <span class="info-box-number">{{$resturant->count()}}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-line-chart"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">orders</span>
                <span class="info-box-number">{{$order->count()}}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-line-chart"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">classifications</span>
                <span class="info-box-number">{{$classification->count()}}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-orange"><i class="fa fa-home"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">cities</span>
                <span class="info-box-number">{{$city->count()}}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-institution"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">regions</span>
                <span class="info-box-number">{{$region->count()}}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-secondary"><i class="fa fa-navicon"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">products</span>
                <span class="info-box-number">{{$product->count()}}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-secondary"><i class="fa fa-navicon"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">payments</span>
                <span class="info-box-number">{{$payment->count()}}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-secondary"><i class="fa fa-navicon"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">offers</span>
                <span class="info-box-number">{{$offer->count()}}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-secondary"><i class="fa fa-navicon"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">payment methods</span>
                <span class="info-box-number">{{$paymentmethod->count()}}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-navy"><i class="fa fa-phone"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">contacts</span>
                <span class="info-box-number">{{$contact->count()}}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-heart"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">comments</span>
                <span class="info-box-number">{{$comment->count()}}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-gray-light"><i class="fa fa-cogs"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">settings</span>
                <span class="info-box-number">{{$setting->count()}}</span>
            </div>
        </div>
    </div>
    {{--        <div class="box">--}}
    {{--            <div class="box-header with-border">--}}
    {{--                <h3 class="box-title">Title</h3>--}}
    {{--                <div class="box-tools pull-right">--}}
    {{--                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"--}}
    {{--                        title="Collapse">--}}
    {{--                    <i class="fa fa-minus"></i></button>--}}
    {{--                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">--}}
    {{--                    <i class="fa fa-times"></i></button>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--            <div class="box-body">--}}
    {{--                @if (session('status'))--}}
    {{--                    <div class="alert alert-success" role="alert">--}}
    {{--                        {{ session('status') }}--}}
    {{--                    </div>--}}
    {{--                @endif--}}
    {{--                You are logged in!--}}
    {{--            </div>--}}
    {{--            <div class="box-footer">--}}
    {{--                Footer--}}
    {{--            </div>--}}
    {{--        </div>--}}
</section>
@endsection
