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
use App\Models\User;
use App\Notifications\invoices\AddInvoiceToDatabase;
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
            'status' => '?????? ????????????',
            'created_by' => Auth::user()->name
        ]);

        Invoice_details::create([
            'invoice_id' => $invoice->id,
            'value_status' => 2,
            'status' => '?????? ????????????',
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

        // Send Notification to owner as database
        Notification::send(User::role('owner')->get(),new AddInvoiceToDatabase($invoice->id));

        return redirect()->route('invoices.index')->with('add', '???? ?????????? ???????????????? ??????????');
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

        return redirect()->back()->with('edit','???? ?????????? ???????????????? ??????????');
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

        return redirect()->back()->withDelete("???? ?????? ???????????????? ??????????");
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
        // ???????????? ??????????
        if($request->status == 3){
            $invoice->update([
                'value_status' => 3,
                'status' => "???????????? ??????????"
            ]);

            Invoice_details::create([
                "invoice_id" => $invoice->id,
                'value_status' => 3,
                'status' => "???????????? ??????????",
                "Payment_Date" => $request->payment_date
            ]);
        }elseif($request->status == 1){
            $invoice->update([
                'value_status' => 1,
                'status' => "????????????"
            ]);

            Invoice_details::create([
                "invoice_id" => $invoice->id,
                'value_status' => 1,
                'status' => "????????????",
                "Payment_Date" => $request->payment_date
            ]);
        }

        return redirect("invoices")->withEdit("???? ?????????? ???????????? ??????????");
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

        return redirect()->route("invoicesArchive.index")->withAdd("???? ?????? ???????????????? ?????? ??????????????");
    }

    public function unArchive(Request $request){
        Invoice::withTrashed()->find($request->id)->restore();

        return redirect()->route("invoices.index")->withAdd("???? ?????????? ???????????????? ???? ??????????????");
    }

    public function printInvoice(Invoice $invoice){
        return view('invoices.print.printInvoice',['invoice'=>$invoice]);
    }

    public function export() 
    {
        return Excel::download(new InvoiceExport, 'invoices.xlsx');
    }

    public function markAllAsRead(){
        $unReadNotifications = auth()->user()->unreadNotifications;

        if($unReadNotifications){
            $unReadNotifications->markAsRead();
        }

        return redirect()->back();
    }

    public function markAsRead($id){
        $notification = auth()->user()->Notifications->where('id',$id)->first();
        $notification->markAsRead();
        return redirect()->route('invoiceDetails.show',$notification->data['id']);
    }
}
