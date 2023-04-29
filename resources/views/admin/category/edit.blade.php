@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">Edit Category</div>

                <div class="card-body">
                    <form action="{{route ('category.update',$category->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                        <input type="hidden" name="id" value="{{$category->id}}">
                        <div class="form-group mb-3">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control" value="{{$category->name}}">
                        </div>
                        <div class="form-group">
                            <label for="">Image</label>
                            <input type="file" name="image" class="form-control" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])"><br>
                            <img width="100" src="" id="blah" alt="">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="update" class="btn btn-success mt-2">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
