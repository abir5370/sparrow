@extends('layouts.dashboard')


@section('content')
<div class="container-fluid">
    @can('product_list')
        <div class="card">
            @if(session('delete'))
                <div class="alert alert-success">{{session('delete')}}</div>
            @endif
            <div class="card-header">
                <h3 class="card-title">Product List</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>si</th>
                        <th>product</th>
                        <th>brand</th>
                        <th>price</th>
                        <th>discount</th>
                        <th>category</th>
                        <th>subcategory</th>
                        <th>preview</th>
                        <th>action</th>
                    </tr>
                    @foreach($products as $key=>$product)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$product->product_name}}</td>
                            <td>{{$product->brand}}</td>
                            <td>{{$product->price}}</td>
                            <td>{{$product->discount}}%</td>
                            <td>
                                @if(App\Models\Category::where('id',$product->category_id)->exists())
                                    {{$product->rel_to_category->name}}
                                @else
                                    unkhon
                                @endif
                            </td>
                            <td>
                                @if(App\Models\Subcategory::where('id',$product->subcategory_id)->exists())
                                {{$product->rel_to_subcategory->subcategory_name}}
                            @else
                                unkhon
                            @endif
                            </td>
                            <td>
                            <img width="50" src="{{asset('uploads/product/preview/'.$product->preview)}}" alt=""> 
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                        <svg width="30px" height="30px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu">
                                        @can('product_inventoy')
                                            <a class="dropdown-item" href="{{route('product.inventory',$product->id)}}">Inventory</a>
                                        @endcan
                                    
                                        @can('product_delete')
                                            <a class="dropdown-item" href="{{route('product.delete',$product->id)}}">Delete</a>
                                        @endcan
                                    
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


@endsection