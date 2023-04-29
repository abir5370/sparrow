@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8">
            @if (session('coupon_delete'))
                <div class="alert alert-success">{{ session('coupon_delete') }}</div>
            @endif
            @can('coupon')
                <div class="card">
                    <div class="card-header">Coupon List</div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <th>Si</th>
                                <th>Coupon</th>
                                <th>Discount</th>
                                <th>Expire Date</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($coupons as $key=>$coupon)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $coupon->coupon_name }}</td>
                                    <td>{{ $coupon->discount }} {{ ($coupon->type == 1)?'%':'TK' }}</td>
                                    <td>{{ $coupon->expire }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                                <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('coupon.delete',$coupon->id) }}">Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            
                        </table>
                    </div>
                </div> 
            @endcan
            
        </div>
        @can('add coupon')
            <div class="col-lg-4">
                @if(session('coupon'))
                    <div class="alert alert-success">{{ session('coupon') }}</div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Add Coupon</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('add.coupon') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="">Coupon Name</label>
                                <input type="text"  name="coupon_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Discount%</label>
                                <input type="number"  name="discount" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Expire Date</label>
                                <input type="date" name="expire_date" class="form-control">
                            </div>
                            <div class="form-group">
                                <select name="type" class="form-control">
                                    <option value="">--select type--</option>
                                    <option value="1">Percentage</option>
                                    <option value="2">Solid Amount</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success" value="Add Coupon"> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan
        
    </div>
</div>


@endsection