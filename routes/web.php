<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\RecorddataController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Models\User;
use App\Http\Controllers\ExcelImportController;
use App\Http\Controllers\AdminExportController;

Route::get('/', function () {
    return view('home');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [UserController::class, 'create'])->name('register.create');
Route::post('/register', [UserController::class, 'store'])->name('register.store');

Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('/send-test-email', [MailController::class, 'sendTestEmail']);

Route::get('/admin/homepage', [HomepageController::class, 'adminHomepage'])->name('admin.homepage');
Route::get('/User/homepage', [HomepageController::class, 'userHomepage'])->name('user.homepage');

Route::get('/admin/editprofile', [ProfileController::class, 'edit'])->name('admin.editprofile');
Route::get('/User/editprofile', [ProfileController::class, 'edit'])->name('user.editprofile');
Route::post('/admin/editprofile', [ProfileController::class, 'update'])->name('admin.updateprofile');
Route::post('/User/editprofile', [ProfileController::class, 'update'])->name('User.updateprofile');

Route::post('/search-id_card', [RecorddataController::class, 'searchIdCard']);

Route::get('admin/manageuser', [AdminController::class, 'manageUsers'])->name('admin.manageuser');
Route::post('/admin/changeRole/{userId}', [AdminController::class, 'changeRole'])->name('admin.changeRole');

Route::get('/admin/form', function () {
    return view('/admin/form'); 
});

Route::get('/admin/about', function () {
    return view('/admin/about');
});

Route::get('/admin/record', [RecorddataController::class, 'index'])->name('recorddata.index');
Route::get('/admin/addrecord', [RecorddataController::class, 'create'])->name('recorddata.create');
Route::post('/admin/addrecord', [RecorddataController::class, 'store'])->name('recorddata.store');
// Route สำหรับค้นหาข้อมูลด้วยวันที่
//Route::get('/admin/editrecord', [RecordDataController::class, 'searchByDate'])->name('searchByDate');

// Route สำหรับการแก้ไขข้อมูล โดยใช้ id
Route::get('/admin/editrecord/{id}', [RecordDataController::class, 'edit'])->name('recorddata.edit');
Route::put('/admin/editrecord/{id}', [RecordDataController::class, 'update'])->name('recorddata.update');


Route::delete('/admin/record/{id}', [RecordDataController::class, 'destroy'])->name('recorddata.destroy');
Route::get('/admin/search', [RecorddataController::class, 'search'])->name('recorddata.search');

Route::post('/select-recorder', [UserController::class, 'selectRecorder'])->name('selectRecorder');

// Route (web.php)
Route::post('admin/importfile', [ExcelImportController::class, 'import'])->name('import');
Route::get('/admin/export', [AdminExportController::class, 'export']);

Route::get('/admin/dashboard', function () {
    return view('/admin/dashboard');
});

Route::get('/admin/record_general_information', function () {
    return view('/admin/record_general_information');
});

Route::get('/User/dashboard', function () {
    return view('/User/dashboard');
});

Route::get('/User/record', function () {
    return view('/User/record');
});

Route::get('/User/about', function () {
    return view('/User/about');
});





