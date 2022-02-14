<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Section;
use Illuminate\Http\Request;

class CustomerReportsController extends Controller
{
    public function index(){
        $sections = Section::all();
        return view('reports.customerReports',['sections'=>$sections]);
    }

    public function search(Request $request){
        if($request->section_id && $request->product_id && !$request->start_at && !$request->end_at){
            $invoices = Invoice::where('section_id',$request->section_id)->where('product_id',$request->product_id)->get();
        }else{
            $start_at = $request->start_at;
            $end_at = $request->end_at;
            $invoices = Invoice::whereBetween('invoice_date',[$start_at,$end_at])->where('section_id',$request->section_id)->where('product_id',$request->product_id)->get();
        }

        $sections = Section::all();
        return view('reports.customerReports', ['sections'=>$sections])->withDetails($invoices);

    }
}
