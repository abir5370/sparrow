@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-lg-12">
        @can('order')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Order List</h3>
                </div>
                <div class="card-body">
                    <table class="table table_striped">
                        <tr>
                            <th>SL</th>
                            <th>Order Id</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Sub Total</th>
                            <th>Discount</th>
                            <th>Charge</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        @foreach($orders as $sl=>$order)
                            <tr>
                                <td>{{ $sl+1 }}</td>
                                <td>{{ $order->order_id }}</td>
                                <td>{{ $order->rel_to_customer->name }}</td>
                                <td>{{ $order->total }}</td>
                                <td>{{ $order->sub_total }}</td>
                                <td>{{ $order->discount }}</td>
                                <td>{{ $order->charge }}</td>
                                <td>
                                    @php
                                        if($order->status == 1){
                                            echo '<span class="badge badge-primary">Placed</span>';
                                        }
                                    else if($order->status == 2){
                                            echo '<span class="badge badge-info">Processing</span>';
                                        }
                                        else if($order->status == 3){
                                            echo '<span class="badge badge-warning">Packeging</span>';
                                        }
                                        else if($order->status == 4){
                                            echo '<span class="badge badge-secondary">Ready to Deliver</span>';
                                        }
                                        else if($order->status == 5){
                                            echo '<span class="badge badge-light">Shipped</span>';
                                        }
                                        else {
                                            echo '<span class="badge badge-success">Delivered</span>';
                                        }
                                    @endphp
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                            <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                        </button>
                                        <div class="dropdown-menu">
                                            <form action="{{ route('order.status') }}" method="POST">
                                            @csrf
                                                <button name="status" value="{{ $order->order_id.','.'1' }}" class="dropdown-item">Placed</button>
                                                <button name="status" value="{{ $order->order_id.','.'2' }}" class="dropdown-item">Processing</button>
                                                <button name="status" value="{{ $order->order_id.','.'3' }}" class="dropdown-item">Packeging</button>
                                                <button name="status" value="{{ $order->order_id.','.'4' }}" class="dropdown-item">Ready to Deliver</button>
                                                <button name="status" value="{{ $order->order_id.','.'5' }}" class="dropdown-item">Shipped</button>
                                                <button name="status" value="{{ $order->order_id.','.'6' }}" class="dropdown-item">Delivered</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </form>
                    </table>
                </div>
            </div>
        @endcan
        
    </div>
</div>

@endsection