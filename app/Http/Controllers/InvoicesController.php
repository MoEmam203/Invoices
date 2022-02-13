<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Models\Invoice;
use App\Models\Invoice_attachment;
use App\Models\Invoice_details;
use App\Models\Product;
use App\Models\Section;
use App\Notifications\invoices\AddInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use App\Exports\InvoiceExport;
use Maatwebsite\Excel\Facades\Excel;

class InvoicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:invoices', ['only' => ['index']]);
        $this->middleware('permission:add invoice', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit invoice', ['only' => ['edit', 'update']]);
        $this->middleware('permission:remove invoice', ['only' => ['destroy']]);
        $this->middleware('permission:change invoice status', ['only' => ['updateInvoiceStatus']]);
        $this->middleware('permission:paid invoices', ['only' => ['paidInvoices']]);
        $this->middleware('permission:unpaid invoices', ['only' => ['unPaidInvoices']]);
        $this->middleware('permission:partial paid invoices', ['only' => ['partialPaidInvoices']]);
        $this->middleware('permission:archive invoice', ['only' => ['archive','unArchive']]);
        $this->middleware('permission:print invoice', ['only' => ['printInvoice']]);
        $this->middleware('permission:export invoice as excel', ['only' => ['export']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::all();
        return view('invoices.index',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Section::all();
        return view('invoices.create',compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceRequest $request)
    {
        $invoice = Invoice::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'product_id' => $request->product_id,
            'section_id' => $request->section_id,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'value_vat' => $request->value_vat,
            'rate_vat' => $request->rate_vat,
            'total' => $request->total,
            'note' => $request->note,
            'value_status' => 2,
            'status' => 'غير مدفوعة',
            'created_by' => Auth::user()->name
        ]);

        Invoice_details::create([
            'invoice_id' => $invoice->id,
            'value_status' => 2,
            'status' => 'غير مدفوعة',
        ]);

        // Save Attachment
        if($request->hasFile('attachment')){
            $attachment = $request->file('attachment');
            $attachment_name = $attachment->getClientOriginalName();

            Invoice_attachment::create([
                'file_name' => $attachment_name,
                'invoice_id' => $invoice->id
            ]);

            // move file 
            $request->attachment->move(public_path('Attachments/Invoices/' . $request->invoice_number), $attachment_name);
        }

        // send Email
        $user = auth()->user();
        Notification::send($user, new AddInvoice($invoice->id));

        return redirect()->route('invoices.index')->with('add', 'تم اضافة الفاتورة بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        $sections = Section::all();

        return view('invoices.edit',compact('invoice','sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(InvoiceRequest $request, Invoice $invoice)
    {

        $invoice->update($request->validated());

        return redirect()->back()->with('edit','تم تعديل الفاتورة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $invoice = Invoice::find($request->id);

        Storage::disk("attachment")->deleteDirectory($invoice->invoice_number);

        // Delete From DB also
        $invoice->forceDelete();

        return redirect()->back()->withDelete("تم حذف الفاتورة بنجاح");
    }

    public function getProductsBySectionID($id){
        $products = Product::where('section_id',$id)->pluck('product_name','id');
        return json_decode($products);
    }


    public function showDetails(Invoice $invoice){
        return view('invoices.invoiceDetails',
            [
                'invoice' => $invoice,
                'details' => $invoice->details,
                'attachments' => $invoice->attachments
            ]
        );
    }

    public function showInvoiceStatus(Invoice $invoice){
        return view('invoices.showStatus',["invoice" => $invoice]);
    }

    public function updateInvoiceStatus(Invoice $invoice,Request $request){
        // مدفوعة جزئيا
        if($request->status == 3){
            $invoice->update([
                'value_status' => 3,
                'status' => "مدفوعة جزئيا"
            ]);

            Invoice_details::create([
                "invoice_id" => $invoice->id,
                'value_status' => 3,
                'status' => "مدفوعة جزئيا",
                "Payment_Date" => $request->payment_date
            ]);
        }elseif($request->status == 1){
            $invoice->update([
                'value_status' => 1,
                'status' => "مدفوعة"
            ]);

            Invoice_details::create([
                "invoice_id" => $invoice->id,
                'value_status' => 1,
                'status' => "مدفوعة",
                "Payment_Date" => $request->payment_date
            ]);
        }

        return redirect("invoices")->withEdit("تم تعديل الحالة بنجاج");
    }

    public function paidInvoices(){
        $invoices = Invoice::where('value_status',1)->get();
        return view("invoices.paidInvoices",['invoices'=>$invoices]);
    }

    public function unPaidInvoices(){
        $invoices = Invoice::where('value_status',2)->get();
        return view("invoices.unPaidInvoices",['invoices'=>$invoices]);
    }

    public function partialPaidInvoices(){
        $invoices = Invoice::where('value_status',3)->get();
        return view("invoices.partialPaidInvoices",['invoices'=>$invoices]);
    }

    public function archive(Request $request){
        $invoice = Invoice::find($request->id);

        $invoice->delete();

        return redirect()->route("invoicesArchive.index")->withAdd("تم نقل الفاتورة الي الارشيف");
    }

    public function unArchive(Request $request){
        Invoice::withTrashed()->find($request->id)->restore();

        return redirect()->route("invoices.index")->withAdd("تم اعادة الفاتورة من الارشيف");
    }

    public function printInvoice(Invoice $invoice){
        return view('invoices.print.printInvoice',['invoice'=>$invoice]);
    }

    public function export() 
    {
        return Excel::download(new InvoiceExport, 'invoices.xlsx');
    }
}
