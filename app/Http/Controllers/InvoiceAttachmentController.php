<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Invoice_attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'invoice_id' => "required|exists:invoices,id",
                "attachment" => "required|file|mimes:png,jpg,jpeg,pdf"
            ]
        );

        $attachment = $request->file('attachment');
        $attachment_name = $attachment->getClientOriginalName();

        Invoice_attachment::create([
            'file_name' => $attachment_name,
            'invoice_id' => $request->invoice_id
        ]);

        // move file 
        $request->attachment->move(public_path('Attachments/Invoices/' . $request->invoice_number), $attachment_name);

        return redirect()->back()->with('add',"تم اضافة الملف بنجاح");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice_attachment  $invoice_attachment
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice,$file_name)
    {
        $file = Storage::disk('attachment')->getDriver()->getAdapter()->applyPathPrefix($invoice->invoice_number.'/'.$file_name);
        return response()->file($file);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice_attachment  $invoice_attachment
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice_attachment $invoice_attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice_attachment  $invoice_attachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice_attachment $invoice_attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice_attachment  $invoice_attachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // dd($request);
        Invoice_attachment::findOrFail($request->id)->delete();
        Storage::disk('attachment')->delete($request->invoice_number.'/'.$request->file_name);
        return redirect()->back()->with('delete','تم حذف المرفق بنجاج');
    }

    // Download Attachment
    public function download(Invoice $invoice,$file_name)
    {
        $file = Storage::disk('attachment')->getDriver()->getAdapter()->applyPathPrefix($invoice->invoice_number.'/'.$file_name);
        return response()->download($file);
    }
}
