@extends('layouts.app')

@section('content')
@section('page_title')
    Details of Order Number {{$records->id}}
@endsection
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">details of order</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <div id="print-area">
                    <table class="table table-bordered" id="example1">
                        <thead>
                        <tr class="bg-info">
                            <th class="text-center">ID</th>
                            <th class="text-center">Notes</th>
                            <th class="text-center">State</th>
                            <th class="text-center">Client Name</th>
                            <th class="text-center">Resturant Name</th>
                            <th class="text-center">Payment Method</th>
                            <th class="text-center">Cost</th>
                            <th class="text-center">Delivery Cost</th>
                            <th class="text-center">Total Price</th>
                            <th class="text-center">Address</th>
                            <th class="text-center">Commission</th>
                            <th class="text-center">Net</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">{{$records->id}}</td>
                                <td class="text-center">{{$records->notes}}</td>
                                <td class="text-center">{{$records->state}}</td>
                                <td class="text-center">{{$records->client->name}}</td>
                                <td class="text-center">{{$records->resturant->name}}</td>
                                <td class="text-center">{{$records->paymentmethod->name}}</td>
                                <td class="text-center">{{$records->cost}}</td>
                                <td class="text-center">{{$records->delivery_cost}}</td>
                                <td class="text-center">{{$records->total_price}}</td>
                                <td class="text-center">{{$records->address}}</td>
                                <td class="text-center">{{$records->commission}}</td>
                                <td class="text-center">{{$records->net}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <a href="{{url(route('order.index'))}}" class="btn btn-sm btn-primary"><i class="fa fa-backward"></i> Back</a>
                <button class="btn btn-sm btn-success print-btn"><i class="fa fa-print"></i> print</button>
            </div>
        </div>
    </div>
</section>
@push('print-order')
    <script>
        $(document).on('click','.print-btn',function () {
            $('#print-area').printThis();
        });
    </script>
@endpush
@endsection
