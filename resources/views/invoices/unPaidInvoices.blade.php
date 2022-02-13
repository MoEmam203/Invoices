@extends('layouts.master')
@section('title','قائمة الفواتير الغير المدفوعة')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    قائمة الفواتير الغير المدفوعة</span>
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
                <div class="card-body">
                    <div class="table-responsive">
                        @include('errors')
                        <table class="table text-md-nowrap" id="example1" data-page-length='50'>
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">رقم الفاتورة</th>
                                    <th class="wd-20p border-bottom-0">تاريخ الفاتورة</th>
                                    <th class="wd-20p border-bottom-0">تاريخ الاستحقاق</th>
                                    <th class="wd-15p border-bottom-0">القسم</th>
                                    <th class="wd-10p border-bottom-0">المنتج</th>
                                    <th class="wd-25p border-bottom-0">مبلغ التحصيل</th>
                                    <th class="wd-25p border-bottom-0">مبلغ العمولة</th>
                                    <th class="wd-25p border-bottom-0">الخصم</th>
                                    <th class="wd-25p border-bottom-0">نسبة الضريبة</th>
                                    <th class="wd-25p border-bottom-0">قيمة الضريبة</th>
                                    <th class="wd-25p border-bottom-0">الاجمالي</th>
                                    <th class="wd-25p border-bottom-0">الحالة</th>
                                    <th class="wd-25p border-bottom-0">ملاحظات</th>
                                    <th class="wd-25p border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($invoices as $key => $invoice)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $invoice->invoice_number }}</td>
                                        <td>{{ $invoice->invoice_date }}</td>
                                        <td>{{ $invoice->due_date }}</td>
                                        <td>
                                            <a href="{{ route('invoiceDetails.show',$invoice) }}">
                                                {{ $invoice->section->section_name }}
                                            </a>
                                        </td>
                                        <td>{{ $invoice->product->product_name }}</td>
                                        <td>{{ $invoice->amount_collection }}</td>
                                        <td>{{ $invoice->amount_commission }}</td>
                                        <td>{{ $invoice->discount }}</td>
                                        <td>{{ $invoice->rate_vat }}%</td>
                                        <td>{{ $invoice->value_vat }}</td>
                                        <td>{{ $invoice->total }}</td>
                                        <td>
                                            @if ($invoice->value_status == 1)
                                                <span class="text-success">{{ $invoice->status }}</span>
                                            @elseif ($invoice->value_status == 2)
                                                <span class="text-danger">{{ $invoice->status }}</span>
                                            @else
                                                <span class="text-warning">{{ $invoice->status }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $invoice->note }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                    id="dropdownMenuButton" type="button">العمليات<i class="fas fa-caret-down ml-1"></i></button>
                                                <div class="dropdown-menu tx-13">
                                                    @can('edit invoice')
                                                        <a class="dropdown-item" href="{{ route('invoices.edit',$invoice) }}">
                                                            <i class="las la-pen"></i>
                                                            تعديل الفاتورة
                                                        </a>
                                                    @endcan

                                                    @can('remove invoice')
                                                        <a class="dropdown-item text-danger" data-target="#modaldemo1" data-invoice="{{ $invoice }}" data-toggle="modal" href="#modaldemo1">
                                                            <i class="las la-trash"></i>
                                                            حذف الفاتورة
                                                        </a>
                                                    @endcan

                                                    @can('change invoice status')
                                                        <a class="dropdown-item" href="{{ route('show.invoice.status',$invoice) }}">
                                                            تغيير حالة الفاتورة
                                                        </a>
                                                    @endcan

                                                    @can('archive invoice')
                                                        <a class="dropdown-item text-warning" data-target="#modaldemo2" data-invoice="{{ $invoice }}" data-toggle="modal" href="#modaldemo2">
                                                            <i class="fas fa-archive"></i>
                                                            نقل الي الارشيف
                                                        </a>
                                                    @endcan

                                                    @can('print invoice')
                                                        <a class="dropdown-item" href="{{ route('invoice.print',$invoice) }}">
                                                            <i class="fas fa-print text-success"></i>
                                                            طباعة الفاتورة
                                                        </a>
                                                    @endcan
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <p>لايوجد فواتير</p>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div><!-- bd -->
            </div><!-- bd -->
        </div>
        <!--/div-->
    </div>
    <!-- row closed -->

    <!-- Delete invoice modal -->
    <div class="modal" id="modaldemo1">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">حذف الفاتورة</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <form action="{{ route('invoices.destroy','test') }}" method="post">
                    @csrf
                    @method("DELETE")
                    <div class="modal-body">
                        <p>
                            هل انت متاكد من حذف الفاتورة
                        </p>
                        <input type="hidden" name="id" id="id" value="">
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-danger" type="submit">حذف</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Delete invoice modal -->


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

    <script>
        // Start Delete Modal
        $('#modaldemo1').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice = button.data('invoice')
            var modal = $(this)
            modal.find('.modal-body #id').val(invoice.id);
        })
        // End Delete Modal
    </script>
@endsection