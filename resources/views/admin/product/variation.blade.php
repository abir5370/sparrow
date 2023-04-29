@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
   <div class="row">
        <div class="col-lg-8">
            @can('product_inventoy')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Color List</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <th>si</th>
                                <th>color name</th>
                                <th>color code</th>
                            </tr>
                            @foreach($colors as $key=>$color)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$color->color_name}}</td>
                                    <td><span class="badge rounded-pill" style="background-color: #{{ $color->color_code }}">{{$color->color_name}}</span></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            @endcan
           
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add Color</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('variation.store')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Color Name</label>
                            <input type="text" name="color_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Color Code</label>
                            <input type="text" name="color_code" class="form-control">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" type="submit" name="btn" value="1">Add Color</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
   </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Size List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>si</th>
                            <th>size name</th>
                        </tr>
                        @foreach($sizes as $key=>$size)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$size->size_name}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add Size</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('variation.store')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Size Name</label>
                            <input type="text" name="size_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" type="submit" name="btn2" value="2">Add Size</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
   </div>
</div>



@endsection