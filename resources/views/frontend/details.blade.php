@extends('frontend.master')

@section('content')

<!-- ======================= Top Breadcrubms ======================== -->
<div class="gray py-3">
    <div class="container">
        <div class="row">
            <div class="colxl-12 col-lg-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Library</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->

<!-- ======================= Product Detail ======================== -->
<section class="middle">
    <div class="container">
        <div class="row justify-content-between">
        
            <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
                <div class="quick_view_slide">
                    @foreach ($thamnails as $thumbnail)
                        <div class="single_view_slide">
                            <a href="{{asset('uploads/product/thumbnail/'.$thumbnail->thumbnail)}}" data-lightbox="roadtrip" class="d-block mb-4">
                                <img src="{{asset('uploads/product/thumbnail/'.$thumbnail->thumbnail)}}" class="img-fluid rounded" alt="" />
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12">
                <div class="prd_details pl-3">
                    
                    <div class="prt_01 mb-1"><span class="text-light bg-info rounded px-2 py-1">{{App\Models\Category::where('id',$product_info->first()->category_id)->first()->name}}</span></div>
                    <div class="prt_02 mb-3">
                        <h2 class="ft-bold mb-1">{{$product_info->first()->product_name}}</h2>
                        @php
                            $ratings = 0;
                            if($total_review != 0){
                                $ratings = round($total_star / $total_review);
                            }
                        @endphp
                        <div class="text-left">
                            <div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
                                @php
                                    for($i = 1; $i <= $ratings; $i++){
                                        echo "<i class='fas fa-star filled'></i>";
                                    }
                                    for($l = $ratings +1; $l <= 5; $l++){
                                        echo "<i class='fas fa-star'></i>";
                                    }
                                @endphp
                                {{-- @for($i = 1; $i <= $ratings; $i++)
                                    <i class="fas fa-star filled"></i>
                                @endfor --}}
                                
                                <span class="small">({{ $total_review }} reviews)</span>
                            </div>
                            <div class="elis_rty"><span class="ft-medium text-muted line-through fs-md mr-2">BDT {{$product_info->first()->price}}</span><span class="ft-bold theme-cl fs-lg mr-2">BDT {{$product_info->first()->after_discount}}</span></div>
                        </div>
                    </div>
                    
                    <div class="prt_03 mb-4">
                        <p>{{$product_info->first()->short_desp}}</p>
                    </div>
                    <form action="{{ route('add.cart') }}" method="post">
                            @csrf
                            <div class="prt_04 mb-2">
                                <p class="d-flex align-items-center mb-0 text-dark ft-medium">Color:</p>
                                <div class="text-left">
                                    @php
                                        $color = null;
                                    @endphp
                                    @foreach($availabe_colors as $color)
                                        @if($color->rel_to_color->color_code == null)
                                            <h5 class="text-danger">Not Available</h5>
                                            <input type="hidden" value="1" name="color_id">
                                        @else
                                            <div class="form-check form-option form-check-inline mb-1">
                                                <input class="form-check-input color_id" type="radio" name="color_id" id="white{{$color->rel_to_color->id}}" value="{{ $color->color_id }}">
                                                <label class="form-option-label rounded-circle" for="white{{$color->rel_to_color->id}}"><span class="form-option-color rounded-circle" style="background: #{{ $color->rel_to_color->color_code }}"></span></label>
                                            </div>
                                        @endif
                                        @php
                                            $color = $color->rel_to_color->color_code;
                                        @endphp   
                                    @endforeach
                                </div>
                                    @error('color_id')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                            </div>
                        
                            <div class="prt_04 mb-4">
                                <p class="d-flex align-items-center mb-0 text-dark ft-medium">Size:</p>
                                <div class="text-left pb-0 pt-2" id="size_id">
                                    @if($color != null)
                                        @foreach($sizes as $size)
                                            <div class="form-check size-option form-option form-check-inline mb-2">
                                                <input class="form-check-input" type="radio" name="size" id="28">
                                                <label class="form-option-label" for="28">{{$size->size_name}}</label>
                                            </div>
                                        @endforeach
                                    @else
                                        @foreach (App\Models\Inventory::where('product_id',$product_info->first()->id)->get() as $size )
                                        @if($size->rel_to_size->id == 2)
                                            <div class="form-check size-option form-option form-check-inline mb-2">
                                                <input class="form-check-input" checked type="radio" value="{{ $size->rel_to_size->id }}" name="size_id" id="{{ $size->id }}">
                                                <label class="form-option-label" for={{ $size->id}}>{{ $size->rel_to_size->size_name }}</label>
                                            </div>
                                        @else
                                            <div class="form-check size-option form-option form-check-inline mb-2">
                                                <input class="form-check-input" type="radio" value="{{ $size->rel_to_size->id }}" name="size_id" id="{{ $size->id }}">
                                                <label class="form-option-label" for={{ $size->id}}>{{ $size->rel_to_size->size_name }}</label>
                                            </div>
                                        @endif
                                            
                                        @endforeach
                                    @endif
                                </div>
                                @error('size_id')
                                        <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>
                        
                                <div class="prt_05 mb-4">
                                    <div class="form-row mb-7">
                                        <div class="col-12 col-lg-auto">
                                            <!-- Quantity -->
                                            <select class="mb-2 custom-select" name="quantity">
                                            <option value="1" selected="">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            </select>
                                        </div>
                                        @error('quantity')
                                        <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                        <div class="col-12 col-lg">
                                            <input type="hidden" name="product_id" value="{{ $product_info->first()->id }}">
                                            <!-- Submit -->
                                            <button type="submit" class="btn btn-block custom-height bg-dark mb-2">
                                                <i class="lni lni-shopping-basket mr-2"></i>Add to Cart 
                                            </button>
                                        </div>
                                </form>
                            <div class="col-12 col-lg-auto">
                                <!-- Wishlist -->
                                <button class="btn custom-height btn-default btn-block mb-2 text-dark" data-toggle="button">
                                    <i class="lni lni-heart mr-2"></i>Wishlist
                                </button>
                            </div>
                      </div>
                      @if (session('stock'))
                          <div class="alert alert-warning">{{ session('stock') }}</div>
                      @endif
                    </div>
                    
                    <div class="prt_06">
                        <p class="mb-0 d-flex align-items-center">
                          <span class="mr-4">Share:</span>
                          <a class="d-inline-flex align-items-center justify-content-center p-3 gray circle fs-sm text-muted mr-2" href="#!">
                            <i class="fab fa-twitter position-absolute"></i>
                          </a>
                          <a class="d-inline-flex align-items-center justify-content-center p-3 gray circle fs-sm text-muted mr-2" href="#!">
                            <i class="fab fa-facebook-f position-absolute"></i>
                          </a>
                          <a class="d-inline-flex align-items-center justify-content-center p-3 gray circle fs-sm text-muted" href="#!">
                            <i class="fab fa-pinterest-p position-absolute"></i>
                          </a>
                        </p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ======================= Product Detail End ======================== -->

<!-- ======================= Product Description ======================= -->
<section class="middle">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-xl-11 col-lg-12 col-md-12 col-sm-12">
                <ul class="nav nav-tabs b-0 d-flex align-items-center justify-content-center simple_tab_links mb-4" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="description-tab" href="#description" data-toggle="tab" role="tab" aria-controls="description" aria-selected="true">Description</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="#information" id="information-tab" data-toggle="tab" role="tab" aria-controls="information" aria-selected="false">Additional information</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="#reviews" id="reviews-tab" data-toggle="tab" role="tab" aria-controls="reviews" aria-selected="false">Reviews</a>
                    </li>
                </ul>
                
                <div class="tab-content" id="myTabContent">
                    
                    <!-- Description Content -->
                    <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                        <div class="description_info">
                            <p class="p-0 mb-2">
                                {!!$product_info->first()->long_desp!!}
                            </p>
                        </div>
                    </div>
                    
                    <!-- Additional Content -->
                    <div class="tab-pane fade" id="information" role="tabpanel" aria-labelledby="information-tab">
                        <div class="additionals">
                            <table class="table">
                                <tbody>
                                    <tr>
                                      <th class="ft-medium text-dark">ID</th>
                                      <td>#1253458</td>
                                    </tr>
                                    <tr>
                                      <th class="ft-medium text-dark">SKU</th>
                                      <td>KUM125896</td>
                                    </tr>
                                    <tr>
                                      <th class="ft-medium text-dark">Color</th>
                                      <td>Sky Blue</td>
                                    </tr>
                                    <tr>
                                      <th class="ft-medium text-dark">Size</th>
                                      <td>Xl, 42</td>
                                    </tr>
                                    <tr>
                                      <th class="ft-medium text-dark">Weight</th>
                                      <td>450 Gr</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Reviews Content -->
                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <div class="reviews_info">

                            @foreach ($reviews as $review)
                            <div class="single_rev d-flex align-items-start br-bottom py-3">
                                <div class="single_rev_thumb"><img src="assets/img/team-1.jpg" class="img-fluid circle" width="90" alt="" /></div>
                                <div class="single_rev_caption d-flex align-items-start pl-3">
                                    <div class="single_capt_left">
                                        <h5 class="mb-0 fs-md ft-medium lh-1">{{ $review->rel_to_customer->name }}</h5>
                                        
                                        <div class="single_capt_right">
                                            <div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
                                                @php
                                                    for($i = 1; $i <= $review->star; $i++){
                                                        echo "<i class='fas fa-star filled'></i>";
                                                    }
                                                    for($k = $review->star + 1; $k <= 5; $k++){
                                                        echo "<i class='fas fa-star'></i>";
                                                    }
                                                @endphp
                                                {{-- @for($i=1; $i <= $review->star; $i++)
                                                    <i class="fas fa-star filled"></i>
                                                @endfor --}}
                                            </div>
                                        </div>
                                        <span class="small">{{ $review->updated_at->format('d-m-Y') }}</span>
                                        <p>{{ $review->review }}</p>
                                    </div>
                                    
                                </div>
                            </div>
                            
                            @endforeach
                            
                            
                            
                        </div>
                        @Auth('customerlogin')
                            @if(App\Models\OrderProduct::where('customer_id',Auth::guard('customerlogin')->id())->where('product_id',$product_info->first()->id)->exists())
                                @if(App\Models\OrderProduct::where('customer_id',Auth::guard('customerlogin')->id())->where('product_id',$product_info->first()->id)->where('review', '!=', null)->first() == false)
                                    <div class="reviews_rate">
                                        <form class="row" action="{{ route('review.store') }}" method="POST">
                                            @csrf
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <h4>Submit Rating</h4>
                                            </div>
                                            
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <div class="revie_stars d-flex align-items-center justify-content-between px-2 py-2 gray rounded mb-2 mt-1">
                                                    <div class="srt_013">
                                                        <div class="submit-rating">
                                                        <input id="star-5" type="radio" name="star" value="5" />
                                                        <label for="star-5" title="5 stars">
                                                            <i class="active fa fa-star" aria-hidden="true"></i>
                                                        </label>
                                                        <input id="star-4" type="radio" name="star" value="4" />
                                                        <label for="star-4" title="4 stars">
                                                            <i class="active fa fa-star" aria-hidden="true"></i>
                                                        </label>
                                                        <input id="star-3" type="radio" name="star" value="3" />
                                                        <label for="star-3" title="3 stars">
                                                            <i class="active fa fa-star" aria-hidden="true"></i>
                                                        </label>
                                                        <input id="star-2" type="radio" name="star" value="2" />
                                                        <label for="star-2" title="2 stars">
                                                            <i class="active fa fa-star" aria-hidden="true"></i>
                                                        </label>
                                                        <input id="star-1" type="radio" name="star" value="1" />
                                                        <label for="star-1" title="1 star">
                                                            <i class="active fa fa-star" aria-hidden="true"></i>
                                                        </label>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="srt_014">
                                                        <h6 class="mb-0">5 Star</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="medium text-dark ft-medium">Full Name</label>
                                                    <input type="text" class="form-control" / readonly value="{{ Auth::guard('customerlogin')->user()->name }}">
                                                </div>
                                            </div>
                                            
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="medium text-dark ft-medium">Email Address</label>
                                                    <input type="email" class="form-control" / readonly value="{{ Auth::guard('customerlogin')->user()->email }}">
                                                </div>
                                            </div>
                                            
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <input type="hidden" name="customer_id" value="{{ Auth::guard('customerlogin')->id() }}">

                                                    <input type="hidden" name="product_id" value="{{ $product_info->first()->id }}">

                                                    <label class="medium text-dark ft-medium">Description</label>
                                                    <textarea name="review" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group m-0">
                                                    <button type="submit" class="btn btn-white stretched-link hover-black">Submit Review <i class="lni lni-arrow-right"></i></button>
                                                </div>
                                            </div>
                                            
                                        </form>
                                    </div>
                                @else
                                    <div class="alert alert-success">you already reviewd</div>
                                @endif
                            @else
                                <div class="alert alert-success">you did not purchase this product yet</div>
                            @endif
                        @else
                          <div class="alert alert-success">please login to leave a review <a href="{{ route('customer.reglogin') }}" class="float-right px-4 ">Login</a></div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ======================= Product Description End ==================== -->

<!-- ======================= Similar Products Start ============================ -->
<section class="middle pt-0">
    <div class="container">
        
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center">
                    <h2 class="off_title">Similar Products</h2>
                    <h3 class="ft-bold pt-3">Matching Product</h3>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="slide_items">
                    
                    <!-- single Item -->
                    @foreach ($related_product as $related)
                        <div class="single_itesm">
                            <div class="product_grid card b-0 mb-0">
                                @if ($related->discount)
                                    <div class="badge bg-success text-white position-absolute ft-regular ab-left text-upper">Sale</div>
                                    @endif
                                <div class="card-body p-0">
                                    <div class="shop_thumb position-relative">
                                        <a class="card-img-top d-block overflow-hidden" href="{{ route('details',$related->slug) }}"><img class="card-img-top" src="{{ asset('uploads/product/preview/'.$related->preview) }}" alt="..."></a>
                                    </div>
                                </div>
                                <div class="card-footer b-0 p-3 pb-0 d-flex align-items-start justify-content-center">
                                    <div class="text-left">
                                        <div class="text-center">
                                            <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="{{ route('details',$related->slug) }}">{{ $related->product_name }}</a></h5>
                                            <div class="elis_rty"><span class="ft-bold fs-md text-dark">{{ $related->after_discount }}</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        
    </div>
</section>
<!-- ======================= Similar Products Start ============================ -->

@endsection

@section('footer_script')
    <script>
        $('.color_id').click(function(){
            var color_id = $(this).val();
            var product_id = '{{ $product_info->first()->id }}';
           
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type:'POST',
                url:'/getsize',
                data:{'color_id':color_id, 'product_id':product_id},
                success:function(data){
                    $('#size_id').html(data);
                }
            })

        })
    </script>
    @if (session('success'))
        <script>
            const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
            })

            Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}'
            })
        </script>
    @endif
@endsection
