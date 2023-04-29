@extends('frontend.master')

@section('content')

<!-- End Navigation -->
<div class="clearfix"></div>
<!-- ============================================================== -->
<!-- Top header  -->
<!-- ============================================================== -->

<!-- ======================= Shop Style 1 ======================== -->
<section class="bg-cover" style="background:url({{asset('Frontend/img/banner-2.png') }}) no-repeat;">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="text-left py-5 mt-3 mb-3">
                    <h1 class="ft-medium mb-3">Shop</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ======================= Shop Style 1 ======================== -->


<!-- ======================= Filter Wrap Style 1 ======================== -->
<section class="py-3 br-bottom br-top">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Shop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Women's</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- ============================= Filter Wrap ============================== -->


<!-- ======================= All Product List ======================== -->
<section class="middle">
    <div class="container">
        <div class="row">
            
            <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 p-xl-0">
                <div class="search-sidebar sm-sidebar border">
                    <div class="col-lg-12">
                        <div class="form-group px-3">
                            <a href="{{ route('search') }}" class="btn form-control">Reset</a>
                        </div>
                    </div>
                    <div class="search-sidebar-body">
                        <!-- Single Option -->
                        <div class="single_search_boxed">
                            <div class="widget-boxed-header">
                                <h4><a href="#pricing" data-toggle="collapse" aria-expanded="false" role="button">Pricing</a></h4>
                            </div>
                            <div class="widget-boxed-body collapse show" id="pricing" data-parent="#pricing">
                                <div class="row">
                                    <div class="col-lg-6 pr-1">
                                        <div class="form-group pl-3">
                                            <input type="number" id="min" name="min" value="{{ @$_GET['min'] }}" class="form-control" placeholder="Min">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 pl-1">
                                        <div class="form-group pr-3">
                                            <input type="number" id="max" name="max" value="{{ @$_GET['max'] }}" class="form-control" placeholder="Max">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group px-3">
                                            <button type="submit" id="price_btn" class="btn form-control">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Single Option -->
                        <div class="single_search_boxed">
                            <div class="widget-boxed-header">
                                <h4><a href="#Categories" data-toggle="collapse" aria-expanded="false" role="button">Categories</a></h4>
                            </div>
                            <div class="widget-boxed-body collapse show" id="Categories" data-parent="#Categories">
                                <div class="side-list no-border">
                                    <!-- Single Filter Card -->
                                    <div class="single_filter_card">
                                        <div class="card-body pt-0">
                                            <div class="inner_widget_link">
                                                @foreach ($all_category as $category)
                                                    <ul class="no-ul-list">
                                                        <li>
                                                            <input id="category{{ $category->id }}" class="category_id" name="category" type="radio" value="{{ $category->id }}"
                                                            @if(isset($_GET['category_id']))
                                                                @if ($_GET['category_id'] == $category->id)
                                                                    checked
                                                                @endif
                                                            @endif
                                                            >
                                                            <label for="category{{ $category->id }}" class="checkbox-custom-label">{{ $category->name }}<span>{{ App\Models\Product::where('category_id',$category->id)->count() }}</span></label>
                                                        </li>
                                                    </ul>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Single Option -->
                        <div class="single_search_boxed">
                            <div class="widget-boxed-header">
                                <h4><a href="#brands" data-toggle="collapse" aria-expanded="false" role="button">Brands</a></h4>
                            </div>
                            <div class="widget-boxed-body collapse show" id="brands" data-parent="#brands">
                                <div class="side-list no-border">
                                    <!-- Single Filter Card -->
                                    <div class="single_filter_card">
                                        <div class="card-body pt-0">
                                            <div class="inner_widget_link">
                                                <ul class="no-ul-list">
                                                    <li>
                                                        <input id="brands1" class="checkbox-custom" name="brands" type="radio">
                                                        <label for="brands1" class="checkbox-custom-label">Sumsung<span>142</span></label>
                                                    </li>
                                                    <li>
                                                        <input id="brands2" class="checkbox-custom" name="brands" type="radio">
                                                        <label for="brands2" class="checkbox-custom-label">Apple<span>652</span></label>
                                                    </li>
                                                    <li>
                                                        <input id="brands3" class="checkbox-custom" name="brands" type="radio">
                                                        <label for="brands3" class="checkbox-custom-label">Nike<span>232</span></label>
                                                    </li>
                                                    <li>
                                                        <input id="brands4" class="checkbox-custom" name="brands" type="radio">
                                                        <label for="brands4" class="checkbox-custom-label">Reebok<span>192</span></label>
                                                    </li>
                                                    <li>
                                                        <input id="brands5" class="checkbox-custom" name="brands" type="radio">
                                                        <label for="brands5" class="checkbox-custom-label">Hawai<span>265</span></label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Single Option -->
                        <div class="single_search_boxed">
                            <div class="widget-boxed-header">
                                <h4><a href="#colors" data-toggle="collapse" class="collapsed" aria-expanded="false" role="button">Colors</a></h4>
                            </div>
                            <div class="widget-boxed-body collapse" id="colors" data-parent="#colors">
                                <div class="side-list no-border">
                                    <!-- Single Filter Card -->
                                    <div class="single_filter_card">
                                        <div class="card-body pt-0">
                                            <div class="text-left">
                                                @foreach ($all_color as $color)
                                                    <div class="form-check form-option form-check-inline mb-1">
                                                        <input id="color{{ $color->id }}" class="color_idd" name="color_id" type="radio" value="{{ $color->id }}"
                                                        @if(isset($_GET['color_id']))
                                                            @if ($_GET['color_id'] == $color->id)
                                                                checked
                                                            @endif
                                                        @endif
                                                        >
                                                        <label for="color{{ $color->id }}" class="checkbox-custom-label">{{ $color->color_name }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Single Option -->
                        <div class="single_search_boxed">
                            <div class="widget-boxed-header">
                                <h4><a href="#size" data-toggle="collapse" class="collapsed" aria-expanded="false" role="button">Size</a></h4>
                            </div>
                            <div class="widget-boxed-body collapse" id="size" data-parent="#size">
                                <div class="side-list no-border">
                                    <!-- Single Filter Card -->
                                    <div class="single_filter_card">
                                        <div class="card-body pt-0">
                                            <div class="text-left pb-0 pt-2">
                                                @foreach ($all_size as $size)
                                                    <div class="form-check form-option form-check-inline mb-1">
                                                        <input id="size{{ $size->id }}" class="size_idd" name="size_id" type="radio" value="{{ $size->id }}"
                                                        @if(isset($_GET['size_id']))
                                                            @if ($_GET['size_id'] == $size->id)
                                                                checked
                                                            @endif
                                                        @endif
                                                        >
                                                        <label for="size{{ $size->id }}" class="checkbox-custom-label">{{ $size->size_name }}</label>
                                                    </div> 
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            
            <div class="col-xl-9 col-lg-8 col-md-12 col-sm-12">
                
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="border mb-3 mfliud">
                            <div class="row align-items-center py-2 m-0">
                                <div class="col-xl-3 col-lg-4 col-md-5 col-sm-12">
                                    <h6 class="mb-0">Searched Products: {{ $search_product->count() }}</h6>
                                </div>
                                
                                <div class="col-xl-9 col-lg-8 col-md-7 col-sm-12">
                                    <div class="filter_wraps d-flex align-items-center justify-content-end m-start">
                                        <div class="single_fitres mr-2 br-right">
                                            <select class="custom-select simple" name="short" id="short">
                                              <option value="" selected="">Default Sorting</option>
                                              <option {{ @$_GET['short'] == 1?'selected':'' }} value="1">Sort by price: A-Z</option>
                                              <option {{ @$_GET['short'] == 2?'selected':'' }} value="2">Sort by price: Z-A</option>
                                              <option {{ @$_GET['short'] == 3?'selected':'' }} value="3">Sort by price: Low to High</option>
                                              <option {{ @$_GET['short'] == 4?'selected':'' }} value="4">Sort by price: Hight to Low</option>
                                            </select>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- row -->
                <div class="row align-items-center rows-products">
                    
                    <!-- Single -->
                    @forelse ($search_product as $product)
                        <div class="col-xl-4 col-lg-4 col-md-6 col-6">
                            <div class="product_grid card b-0">
                                @if($product->discount != null)
                                    <div class="badge bg-danger text-white position-absolute ab-right ft-regular ab-left text-upper">{{ $product->discount }}%</div>
                                @else
                                    <div class="badge bg-info text-white position-absolute ab-right ft-regular ab-left text-upper">New</div>
                                @endif
                                
                                <div class="card-body p-0">
                                    <div class="shop_thumb position-relative">
                                        <a class="card-img-top d-block overflow-hidden" href="{{ route('details',$product->slug) }}"><img class="card-img-top" src="{{ asset('uploads/product/preview/'.$product->preview) }}" alt="..."></a>
                                    </div>
                                </div>
                                <div class="card-footer b-0 p-0 pt-2 bg-white">
                                    
                                    <div class="text-left">
                                        <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="{{ route('details',$product->slug) }}">{{ $product->product_name }}</a></h5>
                                        <div class="elis_rty"><span class="ft-bold text-dark fs-sm">TK {{ $product->after_discount }}</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-lg-12 text-center">
                            <h3 class="mt-5 text-danger">No Search Products Found</h3>
                        </div>
                    @endforelse
                    
                    
                    
                </div>
                <!-- row -->
            </div>
        </div>
    </div>
</section>



@endsection