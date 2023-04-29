@extends('layouts.dashboard')

@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                 @if(session('success'))
                    <div class="alert alert-success">{{session('success')}}</div>
                @endif
                <div class="card-header bg-primary text-white">Add Sub Category</div>

                <div class="card-body">
                    <form action="{{route ('subcategory.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$subcategorys->id}}">
                        <div class="form-group mb-3">
                            <label for="">Category Name</label>
                            <select name="category_id" class="form-control">
                                <option value="">--select category--</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{ ($category->id == $subcategorys->category_id?'selected':'') }}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Sub Category Name</label>
                            <input type="text" value="{{$subcategorys->subcategory_name}}" name="subcategory_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Sub Category Image</label>
                            <input type="file" name="subcategory_image" class="form-control" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])"><br>
                            <img width="50" src="{{asset('uploads/subcategory/'.$subcategorys->subcategory_image)}}" id="blah" alt="">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success mt-2">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection
