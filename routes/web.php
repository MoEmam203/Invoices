<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceAttachmentController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('auth.login');
    return redirect()->route('login');
});

Auth::routes(['register'=>false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('invoices', InvoicesController::class);

Route::resource('sections',SectionController::class);

Route::resource('products', ProductController::class);

Route::get('/sectionProducts/{id}',[InvoicesController::class,'getProductsBySectionID']);

Route::get('/invoiceDetails/{invoice}',[InvoicesController::class,'showDetails'])->name('invoiceDetails.show');

Route::get('/viewInvoicesAttachment/{invoice}/{file_name}',[InvoiceAttachmentController::class,'show'])->name('InvoiceAttachment.show');

Route::get('/downloadInvoicesAttachment/{invoice}/{file_name}',[InvoiceAttachmentController::class,'download'])->name('InvoiceAttachment.download');

Route::delete('/deleteInvoicesAttachment',[InvoiceAttachmentController::class,'destroy'])->name('InvoiceAttachment.delete');
Route::post('/invoiceAttachment',[InvoiceAttachmentController::class,'store'])->name('invoiceAttachment.store');

Route::get('/{page}', [AdminController::class,'index']);
