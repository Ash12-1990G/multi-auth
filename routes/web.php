<?php

use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EbookController;
use App\Http\Controllers\Admin\FranchiseController;
use App\Http\Controllers\Admin\GeoLocationController;
use App\Http\Controllers\Admin\Notifications\NotificationController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SyllabusController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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
    return view('index');
});

Auth::routes();//['verify' => true]
// Route::get('/email/verify', function () {
//     return view('auth.verify');
// })->middleware('auth')->name('verification.notice');
// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();
 
//     return redirect('/dashboard');
// })->middleware(['auth', 'signed'])->name('verification.verify');

// Route::post('/email/verification-notification', function (Request $request) {
//     $request->user()->sendEmailVerificationNotification();
 
//     return back()->with('message', 'Verification link sent!');
// })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::group(['middleware' => ['auth']], function() {//,'verified'
    Route::get('dashboard', [DashboardController::class,'index']);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionsController::class);
    Route::get("search",[PermissionsController::class,'index']);
    Route::resource('users', UserController::class);
    Route::resource('students', StudentController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('franchises', FranchiseController::class);
    Route::controller(EbookController::class)->group(function () {
        Route::get('/ebooks/{course}', 'index')->name('ebooks.index');
        Route::get('/ebooks/create/{course}', 'create')->name('ebooks.create');
        Route::post('/ebooks/store', 'store')->name('ebooks.store');
        Route::get('/ebooks/edit/{id}', 'edit')->name('ebooks.edit');
        Route::get('/ebooks/show/{id}', 'show')->name('ebooks.show');
        Route::patch('/ebooks/update/{id}', 'update')->name('ebooks.update');
        Route::delete('/ebooks/destroy/{id}', 'destroy')->name('ebooks.destroy');
    });
    Route::controller(SyllabusController::class)->group(function () {
        Route::get('/syllabus/{course}', 'show')->name('syllabus.show');
        Route::get('/syllabus/create/{course}', 'create')->name('syllabus.create');
        Route::post('/syllabus/store', 'store')->name('syllabus.store');
        Route::get('/syllabus/edit/{id}', 'edit')->name('syllabus.edit');
        Route::patch('/syllabus/update/{id}', 'update')->name('syllabus.update');
    });
    Route::controller(NotificationController::class)->group(function () {
        Route::get('/notifications', 'index')->name('notifications.index');
        Route::post('/notifications/readall', 'readall')->name('notifications.readall');
        Route::post('/notifications/destroy/all', 'destroyAll')->name('notifications.destroyall');
        Route::get('/notifications/view/{id}', 'show')->name('notifications.view');
        Route::patch('/notifications/read/{id}', 'read')->name('notifications.read');
        Route::delete('/notifications/destroy/{id}', 'destroy')->name('notifications.destroy');
    });
    Route::get('/location', [GeoLocationController::class,'index']);
    Route::post('/geolocation', [GeoLocationController::class,'getGeocodeFromAPI'])->name('location.search');
   
});
