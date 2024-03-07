@extends('layouts.master')
@section('css')
    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('title')
تعديل البيانات الشخصية
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Pages</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Edit-Profile</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <!-- Col -->
        <div class="col-lg-4">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="pl-0">
                        <div class="main-profile-overview">
                            <div class="main-img-user profile-user">
                            <img src="{{ asset('user') }}/{{ Auth::user()->profile_photo }} " alt="mdo">
                                <a class="fas fa-camera profile-edit" href="JavaScript:void(0);"></a>
                            </div>
                            <div class="d-flex justify-content-between mg-b-20">
                                <div>
                                    <h5 class="main-profile-name">{{ Auth::user()->name }}</h5>
                                </div>
                            </div>
                            <h6>Bio</h6>
                            <div class="main-profile-bio">
                                {{ $user->bio }}.. <a
                                    href="">More</a>
                            </div><!-- main-profile-bio -->
                            <div class="row">
                                <div class="col-md-4 col mb20">
                                    <h5>947</h5>
                                    <h6 class="text-small text-muted mb-0">Followers</h6>
                                </div>
                                <div class="col-md-4 col mb20">
                                    <h5>583</h5>
                                    <h6 class="text-small text-muted mb-0">Tweets</h6>
                                </div>
                                <div class="col-md-4 col mb20">
                                    <h5>48</h5>
                                    <h6 class="text-small text-muted mb-0">Posts</h6>
                                </div>
                            </div>


                        </div><!-- main-profile-overview -->
                    </div>
                </div>
            </div>
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="main-content-label tx-13 mg-b-25">
                        Conatct
                    </div>
                    <div class="main-profile-contact-list">
                        <div class="media">
                            <div class="media-icon bg-primary-transparent text-primary">
                                <i class="icon ion-md-phone-portrait"></i>
                            </div>
                            <div class="media-body">
                                <span>Mobile</span>
                                <div>
                                 <i class="fa fa-phone"></i> <a href="tel:{{ $user->phone_number }}"> {{ $user->phone_number }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-icon bg-info-transparent text-info">
                                <i class="icon ion-md-locate"></i>
                            </div>
                            <div class="media-body">
                                <span>Current Address</span>
                                <div>
                                    {{ $user->city }}
                                </div>
                            </div>
                        </div>
                    </div><!-- main-profile-contact-list -->
                </div>
            </div>
        </div>

        <!-- Col -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4 main-content-label">البيانات الشخصية</div>
                    <form method="post" action="{{ route('admin.update',Auth::user()->id) }}"
                        enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="form-group mb-3">
                            <label for="title">Name</label>
                            <div>
                                <input type="text" class="form-control"
                                    name="name" value="{{ $user->name }}">
                                @error('name')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="title">Phone number</label>
                            <div>
                                <input type="tel" class="form-control"
                                    name="phone_number" value="{{ $user->phone_number }}">
                                @error('phone_number')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="title">Email</label>
                            <div>
                                <textarea type="text" class="form-control" disabled>{{ $user->email }}</textarea>
                                @error('email')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="title">Bio</label>
                            <div>
                                <textarea class="form-control" name="bio" value="">{{ $user->bio }}</textarea>
                                @error('bio')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="title">City</label>
                            <div>
                                <input type="text" class="form-control" name="city" value="{{ $user->city }}">
                                @error('city')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="user_photo">Photo</label>
                            <div>
                                <input type="file" class="form-control"
                                    name="user_photo">
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary mt-3">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Col -->
    </div>
    <!-- row closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
@endsection
