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
use App\Http\Controllers\PrintController;
use Carbon\Carbon;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SlideshowController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomepageuserController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\UserRecordController; 
use App\Http\Controllers\AdminArticleController;
use App\Http\Controllers\UserArticleController;
use App\Http\Controllers\GuestArticleController;

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
Route::get('/User/editprofile', [ProfileController::class, 'edit'])->name('user.editprofile'); // เปลี่ยนเป็นตัวพิมพ์เล็ก
Route::post('/admin/editprofile', [ProfileController::class, 'update'])->name('admin.updateprofile');
Route::post('/User/editprofile', [ProfileController::class, 'update'])->name('user.updateprofile'); // เปลี่ยนเป็นตัวพิมพ์เล็ก

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
Route::get('/User/viewrecord/{id}', [RecordDataController::class, 'view'])->name('recorddata.view');
Route::delete('/admin/record/{id}', [RecordDataController::class, 'destroy'])->name('recorddata.destroy');
Route::get('/admin/search', [RecorddataController::class, 'search'])->name('recorddata.search');
Route::get('/User/search', [RecorddataController::class, 'Usersearch'])->name('recorddata.Usersearch');
Route::post('/select-recorder', [UserController::class, 'selectRecorder'])->name('selectRecorder');

Route::post('admin/importfile', [ExcelImportController::class, 'import'])->name('import');
Route::get('/admin/export', [AdminExportController::class, 'export']);
Route::get('/admin/print/{id}', [PrintController::class, 'showPrintPage'])->name('admin.print');
Route::get('/admin/edit_form_record', [RecorddataController::class, 'edit_form'])->name('edit_form_record');
Route::put('/admin/update-record', [RecorddataController::class, 'update_record'])->name('update_record');
Route::get('/admin/edit_form_general_information', [RecorddataController::class, 'edit_form_general_information'])->name('edit_form_general_information');
Route::put('/admin/update-general_information', [RecorddataController::class, 'update_form_general_information'])->name('update_form_general_information');
Route::get('/admin/edit_form_disease', [RecorddataController::class, 'edit_form_disease'])->name('edit_form_disease');
Route::put('/admin/update_disease', [RecorddataController::class, 'update_disease'])->name('update_disease');
Route::get('recorddata/{recorddata_id}/edit_general_information/{checkup_id}', [RecorddataController::class, 'edit_general_information'])->name('recorddata.edit_general_information');
Route::delete('/admin/delete_extra_field', [RecorddataController::class, 'deleteExtraField'])->name('delete_extra_field');

// ตัวอย่างใน routes/web.php
Route::post('/admin/update-general-information/{recorddata_id}/{checkup_id}', [RecorddataController::class, 'update_general_information'])->name('recorddata.update_general_information');


Route::get('/admin/dashboard', function () {
    return view('/admin/dashboard');
});

Route::post('/admin/search-by-date', [RecorddataController::class, 'searchByDate'])->name('recorddata.searchByDate');


Route::get('/admin/record_general_information', function () {
    return view('/admin/record_general_information');
});

Route::get('/User/dashboard', function () {
    return view('/User/dashboard');
});

Route::get('/User/record', function () {
    // ดึงข้อมูลจาก Recorddata ทั้งหมด
    $recorddata = \App\Models\Recorddata::orderBy('id', 'desc')->paginate(20); 

    // ใช้งาน Carbon
    $now = Carbon::now(); // จะได้เวลาและวันที่ปัจจุบัน
    $formattedDate = $now->format('Y-m-d H:i:s'); 

    return view('User.record', compact('recorddata', 'formattedDate'));
});

Route::get('/User/viewrecord', function () {
    $recorddata = \App\Models\Recorddata::orderBy('id', 'desc')->paginate(20); 
    return view('User.viewrecord', compact('recorddata')); 
});

//Route::get('/admin/dashboard', function () {
  //  return view('/admin/dashboard');
//});

Route::get('/admin/record_general_information', function () {
    return view('/admin/record_general_information');
});

Route::get('/User/dashboard', function () {
    return view('User/dashboard');
});

Route::get('/User/record', function () {
    return view('/User/record');
});

//Route::get('/User/about', function () {
 //   return view('/User/about');
//});

Route::get('/admin/homepage', [HomepageController::class, 'adminHomepage'])->name('admin.homepage');
Route::get('/User/homepage', [HomepageController::class, 'userHomepage'])->name('User.homepage');


Route::get('/admin/form', function () {
    return view('/admin/form'); 
});

Route::get('/admin/about', function () {
    return view('/admin/about');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/data', [DashboardController::class, 'getData'])->name('dashboard.data');

Route::post('/admin/slideshow/update/{id}', [SlideshowController::class, 'update'])->name('slideshow.update');
Route::delete('/admin/slideshow/delete/{id}', [SlideshowController::class, 'delete'])->name('slideshow.delete');

Route::post('/slideshow/update/{id}', [SlideshowController::class, 'update'])->name('slideshow.update');
Route::delete('/slideshow/delete/{id}', [SlideshowController::class, 'delete'])->name('slideshow.delete');

Route::get('/', [ArticleController::class, 'index'])->name('home');
Route::get('/admin/home', [ArticleController::class, 'index'])->name('home');
Route::get('/admin/homepage', function () {
    return app(ArticleController::class)->index('homepage');
})->name('homepage');

Route::get('/article/{id}', [ArticleController::class, 'show'])->name('article.show');
Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('article.delete');
Route::post('/articles', [ArticleController::class, 'store'])->name('article.store');

Route::get('/form', [ArticleController::class, 'create'])->name('admin.form');
Route::post('/admin/form', [ArticleController::class, 'store'])->name('admin.form.submit');
Route::get('/admin/form', [AdminController::class, 'showForm'])->name('admin.form');
Route::post('/admin/form', [AdminController::class, 'handleForm'])->name('admin.form.submit');
Route::get('/admin/form', [AdminController::class, 'showForm'])->name('admin.form');


Route::post('/admin/form-submit', [AdminController::class, 'submitForm'])->name('admin.form.submit');

Route::get('/view', function () {
    return view('view');
});

Route::get('/User/homepage', [ArticleController::class, 'index'])->name('User.homepage');

Route::get('/home', [ArticleController::class, 'index'])->name('home');

Route::get('/User/homepage', [HomepageuserController::class, 'homepageuser'])->name('User.homepage');
Route::get('/User/homepage', [HomepageuserController::class, 'showHomepage'])->name('User.homepage');

Route::get('/User/about', [AboutController::class, 'userIndex'])->name('User.about');

Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/dashboard/data', [DashboardController::class, 'fetchData'])->name('dashboard.data');

Route::get('/User/recode', [UserRecordController::class, 'index'])->name('userrecode.index');
Route::get('/User/recode/search', [UserRecordController::class, 'search'])->name('userrecode.search');

Route::get('/User/recode', [UserRecordController::class, 'showRecords'])->name('recorddata.show');

Route::get('/guest/article/{id}', [GuestArticleController::class, 'show'])->name('guest.article'); 
Route::get('/User/article/{id}', [UserArticleController::class, 'show'])->name('user.article');
Route::get('/admin/article/{id}', [AdminArticleController::class, 'show'])->name('admin.article');

Route::get('/search', [ArticleController::class, 'search'])->name('search');

Route::get('/User/record', [RecorddataController::class, 'showUserData'])->name('User.recode');
Route::get('/User/record', [UserRecordController::class, 'showUserData'])->name('User.record');

Route::get('/admin/about', [AboutController::class, 'adminIndex'])->name('admin.about');

Route::post('/submit-form', [FormController::class, 'store'])->name('submitform');
Route::get('/admin/homepage', [AdminController::class, 'homepage'])->name('admin.homepage');
Route::get('/admin/homepage', [AdminController::class, 'homepage'])->name('admin.homepage');




