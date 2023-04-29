@extends('frontend.master')


@section('content')
<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
    <div class="killore-new-block-link border mb-3 mt-3">
        <div class="px-3 py-3 ft-medium fs-md text-dark gray">Top Categories</div>
        
        <div class="killore--block-link-content">
            <ul>
                @foreach($sub_categorys as $categori)
                    <li style="font-family: fontawesome"><a href="{{ route('category.product',$categori->id) }}"><i class="{{ $categori->icon }}"></i>{{$categori->name}}</a>    
                    </li>
                @endforeach
                
            </ul>
        </div>
    </div>
</div>

<section class="middle">
    <div class="container">
        <div class="row align-items-center rows-products">			
            <!-- Single -->
            @foreach($find_product as $product)
                <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                    <div class="product_grid card b-0">
                        
                        @if($product->discount != null)
                            <div class="badge bg-danger text-white position-absolute ft-regular ab-right text-upper">{{$product->discount}}%</div>
                        @else
                            <div class="badge bg-info text-white position-absolute ft-regular ab-right text-upper">New</div>
                        @endif
                        <div class="card-body p-0">
                            <div class="shop_thumb position-relative"><a class="card-img-top d-block overflow-hidden" href="{{route('details',$product->slug)}}"><img class="card-img-top" width="" src="{{asset('uploads/product/preview/'.$product->preview)}}" alt="..."></a>
                            </div>
                        </div>
                        <div class="card-footer b-0 p-0 pt-2 bg-white d-flex align-items-start justify-content-between">
                            <div class="text-left">
                                <div class="text-left">
                                    <div class="elso_titl"><span class="small">{{$product->rel_to_category->name}}</span></div>
                                    <h5 class="fs-md mb-0 lh-1 mb-1"><a href="{{route('details',$product->slug)}}">{{$product->product_name}}</a></h5>
                                    <div class="star-rating align-items-center d-flex justify-content-left mb-2 p-0">
                                        @php
                                            $star = App\Models\OrderProduct::where('product_id',$product->id)->whereNotNull('review')->sum('star');

                                            $total_review = App\Models\OrderProduct::where('product_id',$product->id)->whereNotNull('review')->count();

                                            $avg_rating = 0;
                                            if($total_review != 0){
                                                $avg_rating = round($star / $total_review);
                                            }
                                        @endphp

                                        @php
                                            for($x = 1; $x <= $avg_rating; $x++){
                                                echo "<i class='fas fa-star filled'></i>";
                                            }
                                            for($l = $avg_rating +1; $l <= 5; $l++){
                                                echo "<i class='fas fa-star'></i>";
                                            }
                                        @endphp
                                        
                                        
                                    </div>
                                    <div class="elis_rty">
                                        @if($product->discount != null)
                                            <span class="ft-medium text-muted line-through fs-md mr-2">BDT {{$product->price}}</span>
                                        @endif
                                        <span class="ft-bold text-dark fs-sm">BDT {{$product->after_discount}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            {{ $find_product->links() }}
        </div>
    </div>
</section>
@endsection