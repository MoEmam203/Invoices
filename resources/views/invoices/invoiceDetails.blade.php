@extends('layouts.master')
@section('title','تفاصيل الفاتورة')
@section('css')
    <!---Internal  Prism css-->
    <link href="{{URL::asset('assets/plugins/prism/prism.css')}}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{URL::asset('assets/plugins/inputtags/inputtags.css')}}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css')}}" rel="stylesheet">

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
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ التفاصيل</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">
                    <div class="col-xl-12">
                        <!-- div -->
                        <div class="card mg-b-20" id="tabs-style2">
                            <div class="card-body">
                                <div class="main-content-label mg-b-5">
                                    الفاتورة
                                </div>
                                <div class="text-wrap">
                                    <div class="example">
                                        <div class="panel panel-primary tabs-style-2">
                                            <div class=" tab-menu-heading">
                                                <div class="tabs-menu1">
                                                    <!-- Tabs -->
                                                    <ul class="nav panel-tabs main-nav-line">
                                                        <li><a href="#tab4" class="nav-link active" data-toggle="tab">تفاصيل الفاتورة</a></li>
                                                        <li><a href="#tab5" class="nav-link" data-toggle="tab">حالات الدفع</a></li>
                                                        <li><a href="#tab6" class="nav-link" data-toggle="tab">المرفقات</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="panel-body tabs-menu-body main-content-body-right border">
                                                <div class="tab-content">
                                                    @include('errors')
                                                    <div class="tab-pane active" id="tab4">
                                                        <table class="table text-md-nowrap" id="example1" data-page-length='50'>
                                                            <thead>
                                                                <tr>
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
                                                                    <th class="wd-25p border-bottom-0">الحالة الحالية</th>
                                                                    <th class="wd-25p border-bottom-0">ملاحظات</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>{{ $invoice->invoice_number }}</td>
                                                                    <td>{{ $invoice->invoice_date }}</td>
                                                                    <td>{{ $invoice->due_date }}</td>
                                                                    <td>
                                                                        {{ $invoice->section->section_name }}
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
                                                                        <span class="badge badge-pill badge-success">{{ $invoice->status }}</span>
                                                                        @elseif ($invoice->value_status == 2)
                                                                        <span class="badge badge-pill badge-danger">{{ $invoice->status }}</span>
                                                                        @else
                                                                        <span class="badge badge-pill badge-warning">{{ $invoice->status }}</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $invoice->note }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane" id="tab5">
                                                        <table class="table text-md-nowrap" id="example1" data-page-length='50'>
                                                            <thead>
                                                                <tr>
                                                                    <th class="wd-20p border-bottom-0">#</th>
                                                                    <th class="wd-20p border-bottom-0">حالة الفاتورة</th>
                                                                    <th class="wd-20p border-bottom-0">تاريخ الدفع</th>
                                                                    <th class="wd-20p border-bottom-0">اسم المستخدم</th>
                                                                    <th class="wd-20p border-bottom-0">التاريخ</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse ($details as $key => $detail)
                                                                    <tr>
                                                                        <td>{{ $key+1 }}</td>
                                                                        <td>
                                                                            @if ($detail->value_status == 1)
                                                                            <span class="text-success">{{ $detail->status }}</span>
                                                                            @elseif ($detail->value_status == 2)
                                                                            <span class="text-danger">{{ $detail->status }}</span>
                                                                            @else
                                                                            <span class="text-warning">{{ $detail->status }}</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{ $detail->Payment_Date }}</td>
                                                                        <td>{{ $invoice->created_by }}</td>
                                                                        <td>{{ $detail->created_at->diffForHumans() }}</td>
                                                                    </tr>
                                                                @empty
                                                                    <p>لايوجد تفاصيل</p>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane" id="tab6">
                                                        <div class="addAttachment">
                                                            <form action="{{ route('invoiceAttachment.store') }}" method="post" enctype="multipart/form-data">
                                                                @csrf
                                                                <label for="file">رفع مرفق اخر</label>
                                                                <input type="file" name="attachment" class="form-control">
                                                                <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                                                                <button class="btn btn-primary btn-sm my-3">رفع المرفق</button>
                                                            </form>
                                                        </div>
                                                        <table class="table text-md-nowrap" id="example1" data-page-length='50'>
                                                            <thead>
                                                                <tr>
                                                                    <th class="wd-20p border-bottom-0">#</th>
                                                                    <th class="wd-20p border-bottom-0">اسم الملف</th>
                                                                    <th class="wd-20p border-bottom-0">اسم المستخدم</th>
                                                                    <th class="wd-20p border-bottom-0">التاريخ</th>
                                                                    <th class="wd-20p border-bottom-0">العمليات</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse ($attachments as $key => $attachment)
                                                                    <tr>
                                                                        <td>{{ $key+1 }}</td>
                                                                        <td>{{ $attachment->file_name }}</td>
                                                                        <td>{{ $invoice->created_by }}</td>
                                                                        <td>{{ $attachment->created_at->diffForHumans() }}</td>
                                                                        <td>
                                                                            <a
                                                                                href="{{ route('InvoiceAttachment.show',[$invoice,$attachment->file_name]) }}"
                                                                                class="btn btn-sm btn-outline-primary">
                                                                            عرض</a>

                                                                            <a 
                                                                                href="{{ route('InvoiceAttachment.download',[$invoice,$attachment->file_name]) }}" 
                                                                                class="btn btn-sm btn-outline-secondary">
                                                                            تحميل</a>

                                                                            <a class="modal-effect btn btn-sm btn-outline-danger" data-effect="effect-scale" data-attachment="{{ $attachment }}" data-invoice="{{ $invoice }}" data-toggle="modal" href="#modaldemo9" title="حذف">
                                                                                حذف
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <p>لايوجد مرفقات</p>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /div -->

                    <!-- Start delete -->
                    <div class="modal" id="modaldemo9">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">حذف المرفق</h6>
                                    <button aria-label="Close" class="close" data-dismiss="modal"
                                        type="button"><span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="/deleteInvoicesAttachment" method="post">
                                    @method('Delete')
                                    @csrf
                                    <div class="modal-body">
                                        <p>هل انت متاكد من عملية الحذف ؟</p><br>
                                        <input type="hidden" name="id" id="id" value="">
                                        <input type="hidden" name="invoice_number" id="invoice_number" value="">
                                        <input class="form-control" name="file_name" id="file_name" type="text" readonly>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                        <button type="submit" class="btn btn-danger">تاكيد</button>
                                    </div>
                                </form>
                            </div>
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
    <!--Internal  Datepicker js -->
    <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <!-- Internal Select2 js-->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <!-- Internal Jquery.mCustomScrollbar js-->
    <script src="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <!-- Internal Input tags js-->
    <script src="{{URL::asset('assets/plugins/inputtags/inputtags.js')}}"></script>
    <!--- Tabs JS-->
    <script src="{{URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js')}}"></script>
    <script src="{{URL::asset('assets/js/tabs.js')}}"></script>
    <!--Internal  Clipboard js-->
    <script src="{{URL::asset('assets/plugins/clipboard/clipboard.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/clipboard/clipboard.js')}}"></script>
    <!-- Internal Prism js-->
    <script src="{{URL::asset('assets/plugins/prism/prism.js')}}"></script>

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
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var attachment = button.data('attachment')
            var invoice = button.data('invoice')
            var modal = $(this)
            modal.find('.modal-body #id').val(attachment.id);
            modal.find('.modal-body #file_name').val(attachment.file_name);
            modal.find('.modal-body #invoice_number').val(invoice.invoice_number);
        })
        // End Delete Modal
    </script>
@endsection