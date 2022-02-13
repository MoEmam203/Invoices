<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceReportsController extends Controller
{
    public function index(){
        return view('reports.invoiceReports');
    }

    public function search(Request $request){
        // return $request;
        if($request->radio === "1"){
            // بحث بنوع الفاتورة
            if($request->start_at || $request->end_at){
                //بحث بالتاريخ 
                $start_at = $request->start_at;
                $end_at = $request->end_at;
                $type = $request->type;

                $invoices = Invoice::whereBetween('invoice_date',[$start_at,$end_at])->where('status','=',$type)->get();
                // dd($invoices);

                return view('reports.invoiceReports', compact('type', 'start_at', 'end_at'))->withDetails($invoices);
            }else{
                // بجث بنوع الفاتورة فقط
                $type = $request->type;
                $invoices = Invoice::where('status',$type)->get();
                return view('reports.invoiceReports', compact('type'))->withDetails($invoices);
            }
        }else{
            // بحث برقم الفاتورة
            $invoice = Invoice::where('invoice_number',$request->invoice_number)->get();
            return view('reports.invoiceReports')->withDetails($invoice);
        }
    }
}
