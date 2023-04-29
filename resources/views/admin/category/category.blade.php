@extends('layouts.dashboard')

@section('content')
<div class="">
    <div class="row">
    <div class="col-md-8">
        @can('category')
            <div class="card">
                @if(session('delete'))
                    <div class="alert alert-success">{{session('delete')}}</div>
                @endif
                <div class="card-header bg-primary text-white">View Category List</div>

                <div class="card-body">
                   <table class="table table-striped">
                        <tr>
                            <th>si</th>
                            <th>name</th>
                            <th>added_by</th>
                            <th>image</th>
                            <th>icon</th>
                            <th>action</th>
                        </tr>
                        @foreach($categorys as $key=>$category)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                @if(App\Models\User::where('id',$category->added_by)->exists())
                                    {{$category->rel_to_user->name}}
                                @else
                                    unkhown
                                @endif
                                </td>
                                <td>
                                    <img width="75" src="{{asset('uploads/category/'.$category->image)}}" alt="">
                                </td>
                                <td style="font-family: fontawesome"><i class="{{$category->icon}}"></i></td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                            <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                        </button>
                                        <div class="dropdown-menu">
                                            @can('category_edit')
                                                <a class="dropdown-item" href="{{route('category.edit',$category->id)}}">Edit</a>
                                            @endcan
                                            
                                            @can('category_delete')
                                                <a class="dropdown-item" href="{{route('category.delete',$category->id)}}">Delete</a>  
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

        
        @can('add_category')
            <div class="col-md-4">
                <div class="card">
                    @if(session('insert'))
                        <div class="alert alert-success">{{session('insert')}}</div>
                    @endif
                    <div class="card-header bg-primary text-white">Add Category</div>

                    <div class="card-body">
                        <form action="{{route ('store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                            <div class="form-group">
                                @php
                                    $icons = [
                                        'fa-500px',
                                        'fa-address-book',
                                        'fa-address-book-o',
                                        'fa-address-card',
                                        'fa-address-card-o',
                                        'fa-adjust',
                                        'fa-adn',
                                        'fa-align-center',
                                        'fa-align-justify',
                                        'fa-align-left',
                                        'fa-align-right',
                                        'fa-amazon',
                                        'fa-ambulance',
                                        'fa-american-sign-language-interpreting',
                                        'fa-caret-down',
                                        'fa-caret-left',
                                        'fa-caret-right',
                                        'fa-caret-square-o-down',
                                        'fa-caret-square-o-left',
                                        'fa-caret-square-o-right',
                                        'fa-caret-square-o-up',
                                        'fa-caret-up',
                                        'fa-cart-arrow-down',
                                        'fa-cart-plus',
                                        'fa-cc',
                                        'fa-cc-amex',
                                        'fa-cc-diners-club',
                                        'fa-cc-discover',
                                        'fa-cc-jcb',
                                        'fa-cc-mastercard',
                                        'fa-cc-paypal',
                                        'fa-cc-stripe',
                                        'fa-cc-visa',
                                        'fa-certificate', 
                                        'fa-child',
                                        'fa-clock-o',   
                                    ];
                                @endphp
                                <label for="form-label">select icon</label>
                                <div style="font-family: fontawesome; font-size:20px">
                                    @foreach($icons as $icon)
                                        <i class="fa {{$icon}}" data-icon="{{$icon}}"></i>
                                    @endforeach
                                    <input type="text" id="icon" class="form-control" name="icon" placeholder="icon">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Name</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Image</label>
                                <input type="file" name="image" class="form-control" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])"><br>
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
    <div class="col-md-9">
            <div class="card">
                @if(session('success'))
                    <div class="alert alert-success">{{session('success')}}</div>
                @endif
                @if(session('hard_delete'))
                    <div class="alert alert-success">{{session('hard_delete')}}</div>
                @endif
                <div class="card-header bg-primary text-white">Restore Category List</div>

                <div class="card-body">
                   <table class="table table-striped">
                        <tr>
                            <th>si</th>
                            <th>name</th>
                            <th>added_by</th>
                            <th>image</th>
                            <th>icon</th>
                            <th>action</th>
                        </tr>
                        @foreach($trash_categorys as $key=>$category)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    @if(App\Models\User::where('id',$category->added_by)->exists())
                                        {{$category->rel_to_user->name}}
                                    @else
                                        unkhon
                                    @endif
                                </td>
                                <td>
                                    <img width="75" src="{{asset('uploads/category/'.$category->image)}}" alt="">
                                </td>
                                <td style="font-family: fontawesome"><i class="{{$category->icon}}"></i></td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                            <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{route('category.restore',$category->id)}}">Restore</a>
                                            <a class="dropdown-item" href="{{route('category.hard.restore',$category->id)}}">Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                   </table> 
                </div>
            </div>
        </div>
</div>
@endsection

@section('footer_script')
   <script>
        $('.fa').click(function(){
        var icon = $(this).attr('data-icon');
        $('#icon').attr('value',icon);
        });
   </script>
@endsection
