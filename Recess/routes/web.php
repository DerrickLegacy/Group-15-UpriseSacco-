<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PendingRequestController;
use App\Http\Controllers\EmailReportController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\RegisterDepositController;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\CsvController;




use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


/*
======================================================================
=======Admin Routes
=====================================================================
*/

Route::prefix('/admin')->group(function () {
    Route::get('/', [AdminHomeController::class, 'index'])->name('admin.home');
    Route::get('/alerts', [AlertController::class, 'index'])->name('admin.alerts');
    Route::get('/deposits', [DepositController::class, 'index'])->name('admin.deposits');
    Route::post('/registerdeposits', [RegisterDepositController::class, 'register_depo'])->name('admin.registerdeposits');

    Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports');
    Route::get('/reports/loan', [ReportController::class, 'gen_pdf'])->name('admin.reports.loanreport');
    Route::get('/reports/deposit', [ReportController::class, 'gen_perf_pdf'])->name('admin.reports.deposit');
    Route::post('/update_interest', [UpdateController::class, 'update'])->name('admin.update_interest');

    Route::post('/upload-csv', [CsvController::class, 'uploadCsv'])->name('upload.csv');
    Route::post('/uploadloan-csv', [CsvController::class, 'uploadloanCsv'])->name('uploadloan.csv');




    Route::get('/requests', [PendingRequestController::class, 'index'])->name('admin.requests');
    Route::get('/requests/client/{client_id}', [PendingRequestController::class, 'client_details'])->name('admin.requests');
    Route::post('/requests/client/pending/{client_id}/{latest_ref_number}', [PendingRequestController::class, 'pending_login'])->name('admin.requests.pending');


    Route::get('/email-reports', [EmailReportController::class, 'index'])->name('admin.email-reports');
    // Route::get('/email-reports', [EmailReportController::class, 'index'])->name('admin.email-reports')
    Route::get('/members', [MemberController::class, 'index'])->name('admin.member.index');
    Route::get('/member/{id}', [MemberController::class, 'show'])->name('admin.member.show');
    Route::get('/member/{id}/edit', [MemberController::class, 'edit'])->name('admin.member.edit');
    Route::get('/members/create', [MemberController::class, 'create'])->name('admin.member.create');
    Route::post('/members', [MemberController::class, 'store'])->name('admin.member.store');
    Route::put('/member/{id}', [MemberController::class, 'update'])->name('admin.member.update');
    Route::delete('/member', [MemberController::class, 'delete'])->name('admin.member.delete');
    Route::get('/chart', [HighchartController::class, 'handleChart'])->name('admin.chart');
});