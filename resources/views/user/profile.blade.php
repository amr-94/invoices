@extends('layouts.master')
@section('title')
    الصفحة الشخصية
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Pages</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Profile</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-lg-4">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="pl-0">
                        <div class="main-profile-overview">
                            <div class="main-img-user profile-user">
                                <img alt="" src="{{ asset('user') }}/{{ $user->profile_photo }}"><a
                                    class="fas fa-camera profile-edit" href="JavaScript:void(0);"></a>
                            </div>
                            <div class="d-flex justify-content-between mg-b-20">
                                <div>
                                    <h5 class="main-profile-name">{{ $user->name }}</h5>
                                    <a href="{{ route('admin.allmessage') }}">all message</a>
                                    <a href="{{ route('admin.notify') }}">all notify</a>
                                </div>
                            </div>
                            <h6>Bio</h6>
                            <div class="main-profile-bio">
                                {{ $user->bio }} ..
                            </div><!-- main-profile-bio -->
                            <div class="row">
                                <div class="col-md-4 col mb20">
                                    <h5>{{ $user->invoices->count() }}</h5>
                                    <h6 class="text-small text-muted mb-0">invoices</h6>
                                </div>
                            </div>
                            <hr class="mg-y-30">


                        </div><!-- main-profile-overview -->
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
                                                <i class="fa fa-phone"></i> <a href="tel:{{ $user->phone_number }}">
                                                    {{ $user->phone_number }}</a>
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
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">

                    <h2 class="text mb-3 text-danger" style="text-align: center">الفواتير الخاصة بهذا المتسخدم</h2>
                    <div class="table-responsive">
                        <table id="example" class="table key-buttons text-md-nowrap">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">رقم الفاتورة</th>
                                    <th class="border-bottom-0">تاريخ الفاتورة</th>
                                    <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                    <th class="border-bottom-0">المنتج </th>
                                    <th class="border-bottom-0">القسم</th>
                                    <th class="border-bottom-0">الخصم</th>
                                    <th class="border-bottom-0">نسبة الضريبة</th>
                                    <th class="border-bottom-0">قيمة الضريبة</th>
                                    <th class="border-bottom-0">الاجمالى</th>
                                    <th class="border-bottom-0">حالة الفاتورة</th>
                                    <th class="border-bottom-0">ملاحظات </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->invoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->id }}</td>
                                        <td><a href="{{ route('invoices.show', $invoice->id) }}">{{ $invoice->invoice_number }}
                                            </a></td>
                                        <td>{{ $invoice->invoice_Date }}</td>
                                        <td>{{ $invoice->Due_date }}</td>
                                        <td>{{ $invoice->product }}</td>
                                        <td>{{ $invoice->section->section_name }}</td>
                                        <td>{{ $invoice->Discount }}</td>
                                        <td>{{ $invoice->Rate_VAT }}</td>
                                        <td>{{ $invoice->Value_VAT }}</td>
                                        <td>{{ $invoice->Total }}</td>
                                        <td>{{ $invoice->Status }}</td>
                                        <td>{{ $invoice->note }}</td>
                                        <td>
                                            <a class="btn btn-outline-success btn-sm"
                                                href="{{ route('invoices.edit', $invoice->id) }}">تعديل</a>

                                            <button class="btn btn-outline-danger btn-sm " data-id="{{ $invoice->id }}"
                                                data-invoice="{{ $invoice->invoice_number }}" data-toggle="modal"
                                                data-target="#modaldemo10">حذف</button>

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @if (Auth::user()->id !== $user->id)
            <div class="card-body">
                <p style="text-align: center">message to {{ $user->name }}</p>

                <form action="{{ route('admin.send_message', $user->id) }}" method="post" class="form sendmessage">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label"> Title of message</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="title"
                            name="title">
                        @error('title')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label"> Content of message</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="content"></textarea>
                        @error('content')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary" type="submit">send</button>
                    </div>
                </form>
            </div>
        @else
            <div class="card-body">
                <h2 class="text text-danger mb-3" style="text-align: center">الرسائل</h2>
                <table class="table table-srtiped " style="width: 100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>title</th>
                            <th>content</th>
                            <th>from_user</th>
                            <th>Created_at</th>
                        </tr>
                    </thead>


                    <tbody>
                        @foreach ($message as $message)
                            <tr>
                                <td>{{ $message->id }}</td>
                                <td>{{ $message->title }}</td>
                                <td>{{ $message->content }}</td>
                                <td><a
                                        href="{{ route('admin.show', [$message->from_user->id]) }}">{{ $message->from_user->name }}</a>
                                </td>
                                <td>{{ $message->created_at->diffforhumans() }}</td>
                                <td>
                                    <form class="form" action="{{ route('admin.delete_message', $message->id) }}"
                                        method="post">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-outline-danger btn-sm">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @endif

    </div>

    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
@section('css')
@endsection
