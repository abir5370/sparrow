@extends('layouts.dashboard')

@section('content')
<div class="container_fluid">
    @can('add product')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add Product</h3>
            </div>
            <div class="card-body">
                <form action="{{route('product.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <select name="category_id" id="categori_id" class="form-control">
                                    <option value="">--select category--</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <select name="subcategory_id" id="subcategory" class="form-control">
                                    <option value="">--select category--</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="text" class="form-control" name="product_name" placeholder="Product Name">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="number" class="form-control" name="price" placeholder="product Price">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="number" class="form-control" name="discount" placeholder="Discount %">
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <input type="text" class="form-control" name="brand" placeholder="Product Brand">
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <input type="text" class="form-control" name="short_desp" placeholder="Short Description">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <textarea class="form-control" id="summernote" name="long_desp" placeholder="Long Description"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="form-label">Product Preview</label>
                                <input type="file" name="preview" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="form-label">Product Thumbnails</label>
                                <input type="file" class="form-control" multiple name="thumbnail[]">
                            </div>
                        </div>
                        <div class="col-lg-12 mt-3">
                            <div class="form-group text-center">
                                <input type="submit" class="btn btn-primary" value="Add Product">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endcan
</div>
@endsection



@section('footer_script')
    <script>
        $('#categori_id').change(function(){
            var category_id = $(this).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url:'/getsubcategory',
                type:'POST',
                data:{'category': category_id},
                success:function(data){
                    $('#subcategory').html(data);
                }
            });
            
        });
    </script>
    <script>
         $('#summernote').summernote();
    </script>
@endsection