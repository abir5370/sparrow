@extends('layouts.dashboard')

@section('content')
<div class="">
    <div class="row">
    <div class="col-md-8">
        @can('sub_category')
            <div class="card">
                @if(session('delete'))
                    <div class="alert alert-success">{{session('delete')}}</div>
                @endif
                <div class="card-header bg-primary text-white">View Sub Category List</div>

                <div class="card-body">
                   <table class="table table-striped">
                        <tr>
                            <th>si</th>
                            <th>Category</th>
                            <th>Subcategory</th>
                            <th>image</th>
                            <th>action</th>
                        </tr>
                        @foreach($subcategories as $key=>$subcategory)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>
                                    @if(App\Models\Category::where('id',$subcategory->category_id)->exists())
                                    {{$subcategory->rel_to_category->name}}
                                    @else
                                        unkhon
                                    @endif
                                </td>
                                <td>{{$subcategory->subcategory_name}}</td>
                                <td>
                                    <img width="50" src="{{asset('uploads/subcategory/'.$subcategory->subcategory_image)}}" alt="">
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                            <svg width="30px" height="30px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                        </button>
                                        <div class="dropdown-menu">
                                            @can('sub_category_edit')
                                                <a class="dropdown-item" href="{{route('subcategory.edit',$subcategory->id)}}">Edit</a> 
                                            @endcan
                                            
                                            @can('sub_category_delete')
                                                <a class="dropdown-item" href="{{route('subcategory.delete',$subcategory->id)}}">Delete</a> 
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

        
        @can('add_sub_category')
            <div class="col-md-4">
                <div class="card">
                    @if(session('insert'))
                        <div class="alert alert-success">{{session('insert')}}</div>
                    @endif
                    <div class="card-header bg-primary text-white">Add Sub Category</div>

                    <div class="card-body">
                        <form action="{{route ('subcategory.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                            <div class="form-group mb-3">
                                <label for="">Category Name</label>
                                <select name="category_id" class="form-control">
                                    <option value="">--select category--</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Sub Category Name</label>
                                <input type="text" name="subcategory_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Sub Category Image</label>
                                <input type="file" name="subcategory_image" class="form-control" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])"><br>
                                <img width="100" src="" id="blah" alt="">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success mt-2">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan
    </div>
    
</div>
@endsection
