@extends('layouts.master')
@section('title','المنتاجات')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">

    <!---Internal Owl Carousel css-->
    <link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet">
    <!---Internal  Multislider css-->
    <link href="{{URL::asset('assets/plugins/multislider/multislider.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    المنتاجات</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
            <!-- row -->
            <div class="row">
                <!--div-->
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between">
                                <div class="col-sm-6 col-md-4 col-xl-3">
                                    @can('add product')
                                        <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">اضافة منتج</a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                @include('errors')
                                <table class="table text-md-nowrap" id="example2" data-page-length='50'>
                                    <thead>
                                        <tr>
                                            <th class="wd-15p border-bottom-0">#</th>
                                            <th class="wd-15p border-bottom-0">اسم المنتج</th>
                                            <th class="wd-20p border-bottom-0">اسم القسم</th>
                                            <th class="wd-15p border-bottom-0">الوصف</th>
                                            <th class="wd-10p border-bottom-0">العمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($products as $key => $product)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $product->product_name }}</td>
                                                <td>{{ $product->section->section_name }}</td>
                                                <td>{{ $product->description }}</td>
                                                <td>
                                                    @can('edit product')
                                                        <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale" data-product="{{ $product }}" data-toggle="modal" href="#exampleModal2" title="تعديل"><i class="las la-pen"></i></a>
                                                    @endcan
                                                    
                                                    @can('remove product')
                                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale" data-product="{{ $product }}" data-toggle="modal" href="#modaldemo9" title="حذف"><i class="las la-trash"></i></a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @empty
                                            <p>لا يوجد منتجات قم باضافة البعض</p>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- bd -->
                    </div><!-- bd -->
                </div>
                <!--/div-->

                <!-- Modal effects -->
                <div class="modal" id="modaldemo8">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">اضافة منتج</h6><button aria-label="Close" class="close" data-dismiss="modal"
                                    type="button"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <form action="{{ route('products.store') }}" method="post">
                                @csrf
                                <div class="modal-body">
                
                                    <label for="product_name" class="form-label">اسم المنتج *</label>
                                    <input type="text" class="form-control" name="product_name" id="product_name">
                
                                    <select class="form-select form-control my-3" name="section_id" aria-label="Default select example">
                                        <option selected>القسم</option>
                                        @forelse ($sections as $section)
                                            <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                                        @empty
                                            <option value="0">لايوجد اقسام</option>
                                        @endforelse
                                    </select>

                                    <label for="description" class="form-label">وصف المنتج</label>
                                    <textarea class="form-control" name="description" rows="3"></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn ripple btn-primary" type="submit">حفظ المنتج</button>
                                    <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">اغلاق</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End Modal effects-->

                <!-- start edit -->
                <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">تعديل المنتج</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="products/update" method="post" autocomplete="off">
                                @method('PUT')
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input type="hidden" name="id" id="id" value="">
                                        <label for="product_name" class="form-label">اسم المنتج *</label>
                                        <input type="text" class="form-control" name="product_name" id="product_name">
                                    </div>

                                    <div class="form-group">
                                        <select class="form-select form-control my-3" id="section_id" name="section_id" aria-label="Default select example">
                                            @forelse ($sections as $section)
                                                <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                                            @empty
                                                <option value="0">لايوجد اقسام</option>
                                            @endforelse
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="description" class="col-form-label">الوصف:</label>
                                        <textarea class="form-control" id="description" name="description"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">تعديل</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- end edit -->

                <!-- Start delete -->
                <div class="modal" id="modaldemo9">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">حذف المنتج</h6><button aria-label="Close" class="close" data-dismiss="modal"
                                    type="button"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <form action="products/destroy" method="post">
                                @method('Delete')
                                @csrf
                                <div class="modal-body">
                                    <p>هل انت متاكد من عملية الحذف ؟</p><br>
                                    <input type="hidden" name="id" id="id" value="">
                                    <input class="form-control" name="product_name" id="product_name" type="text" readonly>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                    <button type="submit" class="btn btn-danger">تاكيد</button>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
                <!-- End delete -->
            </div>
            <!-- row closed -->
        </div>
        <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>

    <!-- Internal Modal js-->
    <script src="{{URL::asset('assets/js/modal.js')}}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <!-- Internal Select2 js-->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>

    <script>
        // Start Edit Modal
        $('#exampleModal2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var product = button.data('product')
            var modal = $(this)
            modal.find('.modal-body #id').val(product.id);
            modal.find('.modal-body #product_name').val(product.product_name);
            modal.find('.modal-body #description').val(product.description);
            modal.find('.modal-body #section_id').val(product.section.id);
        })
        // End Edit Modal

        // Start Delete Modal
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var product = button.data('product')
            var modal = $(this)
            modal.find('.modal-body #id').val(product.id);
            modal.find('.modal-body #product_name').val(product.product_name);
        })
        // End Delete Modal
    </script>
    
@endsection