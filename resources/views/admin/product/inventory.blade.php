@extends('layouts.dashboard')

@section('content')
<div class="container_fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title text-white">Inventory List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>Si</th>
                            <th>Product name</th>
                            <th>Color name</th>
                            <th>Size name</th>
                            <th>Quantity</th>
                        </tr>
                        @foreach($inventories as $key=>$inventory)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$inventory->rel_to_product->product_name}}</td>
                                <td>{{$inventory->rel_to_color->color_name}}</td>
                                <td>{{$inventory->rel_to_size->size_name}}</td>
                                <td>{{$inventory->quantity}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title text-white">Add Inventory</h3>
                </div>
                <form action="{{route('inventory.store')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control mt-3" readonly value="{{$products->product_name}}">

                        <input type="hidden" name="product_id" value="{{$products->id}}">
                    </div>
                    <div class="form-group">
                        <select name="color_id" class="form-control">
                            <option value="">--select color--</option>
                            @foreach($colors as $color)
                                <option value="{{$color->id}}">{{$color->color_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="size_id" class="form-control">
                            <option value="">--select size--</option>
                            @foreach($sizes as $size)
                                <option value="{{$size->id}}">{{$size->size_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" name="quantity" placeholder="Quantity">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection