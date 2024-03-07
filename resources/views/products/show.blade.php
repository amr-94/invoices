@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Owl Carousel css-->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    <!---Internal  Multislider css-->
    <link href="{{ URL::asset('assets/plugins/multislider/multislider.css') }}" rel="stylesheet">
    <!--- Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('title')
     {{ $product->name}}
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    المنتجات</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')



    @if (session()->has('success'))
        <div class="alert alert-success" id="alert">
            {{ session()->get('success') }}
        </div>
        {{-- @elseif (session()->has('danger'))
                        <div class="alert alert-danger" id="alert">
                            {{ session()->get('danger') }}
                        </div> --}}
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'>
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">اسم المنتج</th>
                                    <th class="border-bottom-0">اسم القسم</th>
                                    <th class="border-bottom-0">تمت اضافته بواسطة</th>
                                    <th class="border-bottom-0">ملاحظات</th>
                                    <th class="border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</a></td>
                                    <td>{{ $product->section->section_name }}</td>
                                    <td>{{ $product->user->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>
                                        <button class="btn btn-outline-success btn-sm" data-name="{{ $product->name }}"
                                            data-id="{{ $product->id }}"
                                            data-section_name="{{ $product->section->section_name }}"
                                            data-description="{{ $product->description }}" data-toggle="modal"
                                            data-target="#edit_Product">تعديل</button>

                                        <button class="btn btn-outline-danger btn-sm " data-id="{{ $product->id }}"
                                            data-name="{{ $product->name }}" data-toggle="modal"
                                            data-target="#modaldemo9">حذف</button>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <h2 class="text mb-3 text-danger" style="text-align: center">الفواتير الخاصة بهذا المنتج</h2>
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
                        @foreach ($invoice as $invoice)
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

        <!-- edit -->
        <div class="modal fade" id="edit_Product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">تعديل منتج</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action='products/update' method="post">
                        @method('put')
                        @csrf
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="title">اسم المنتج :</label>

                                <input type="hidden" class="form-control" name="id" id="id"
                                    value="">

                                <input type="text" class="form-control" name="name" id="name">
                            </div>

                            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
                            <select name="section_id" id="section_name" class="custom-select my-1 mr-sm-2" required>
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                                @endforeach
                            </select>

                            <div class="form-group">
                                <label for="des">ملاحظات :</label>
                                <textarea name="description" cols="20" rows="5" id='description' class="form-control"></textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">تعديل البيانات</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- delete -->
        <div class="modal fade" id="modaldemo9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">حذف المنتج</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="products/destroy" method="post">
                        @method('delete')
                        @csrf
                        <div class="modal-body">
                            <p>هل انت متاكد من عملية الحذف ؟</p><br>
                            <input type="hidden" name="id" id="id" value="">
                            <input class="form-control" name="name" id="name" type="text" readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            <button type="submit" class="btn btn-danger">تاكيد</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <!-- Internal Prism js-->
    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Modal js-->
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>


    <script>
        $('#edit_Product').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var Product_name = button.data('name')
            var section_name = button.data('section_name')
            var id = button.data('id')
            var description = button.data('description')
            var modal = $(this)
            modal.find('.modal-body #Product_name').val(Product_name);
            modal.find('.modal-body #section_name').val(section_name);
            modal.find('.modal-body #description').val(description);
            modal.find('.modal-body #id').val(id);
        })


        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var Product_name = button.data('name')
            var modal = $(this)

            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(Product_name);
        })
    </script>

@endsection
