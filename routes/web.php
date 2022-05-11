<?php

use App\Http\Controllers\Admin\AutocompleteController;
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
use App\Http\Controllers\Admin\StudentCourseController;
use App\Http\Controllers\Admin\SyllabusController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\JoinedCoursesController;
use App\Http\Controllers\Student\Login\StudenLoginController;
use App\Http\Controllers\Student\ProfileController;
use App\Models\Student;
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
    return view('frontend.index');
})->name('front.home');
Route::get('/about-us', function () {
    return view('frontend.aboutus');
})->name('front.aboutus');
Route::get('/contact', function () {
    return view('frontend.contact');
})->name('front.contact');
// Route::group(['middleware' => ['guest']], function () {
//     Route::post('/password/email')->uses('App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//     Route::get('/password/reset')->uses('App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//     Route::get('/password/confirm')->uses('App\Http\Controllers\Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
//     Route::post('/password/confirm')->uses('App\Http\Controllers\Auth\ConfirmPasswordController@confirm');
//     Route::post('/password/reset')->uses('App\Http\Controllers\Auth\ResetPasswordController@reset')->name('password.update');
//     Route::get('/password/reset/{token} ')->uses('App\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
//     Route::post('/logout')->uses('App\Http\Controllers\Auth\LoginController@logout')->name('logout');
// });

// Route::group(['middleware' => ['guest'],'prefix' => 'student'], function () {
//     // Authentication Routes...
//     Route::get('/sigin', [StudenLoginController::class,'index'])->name('student.signin');
//     Route::post('/login', [StudenLoginController::class,'login'])->name('student.login');
    
    
// });

// Route::group(['middleware' => ['guest'],'prefix' => 'admin'], function () {
//     Route::get('/login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
//     Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login')->name('admin.loginsubmit');
    
   
// });

// Route::group(['middleware' => ['guest'],'prefix' => 'customer'], function () {
//     // Authentication Routes...
//     Route::get('/sigin', [StudenLoginController::class,'index'])->name('customer.signin');
//     Route::post('/login', [StudenLoginController::class,'login'])->name('customer.login');
    
// });


// //Auth::routes();//['verify' => true]
// Route::group(['prefix' => 'student'], function () {
//     Route::get('/email/verify', function () {
//         return view('auth.verify');
//     })->middleware('auth')->name('student.verification.notice');
//     Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//         $request->fulfill();
//         return redirect()->route('student.dashboard');

//     })->middleware(['auth', 'signed'])->name('student.verification.verify');
//     Route::post('/email/verification-notification', function (Request $request) {
//         $request->user()->sendEmailVerificationNotification();
    
//         return back()->with('message', 'Verification link sent!');
//     })->middleware(['auth', 'throttle:6,1'])->name('student.verification.send');
// });
// Route::group(['prefix' => 'customer'], function () {
//     Route::get('/email/verify', function () {
//         return view('auth.verify');
//     })->middleware('auth')->name('customer.verification.notice');
//     Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//         $request->fulfill();
//         return redirect()->route('customer.dashboard');

//     })->middleware(['auth', 'signed'])->name('customer.verification.verify');
//     Route::post('/email/verification-notification', function (Request $request) {
//         $request->user()->sendEmailVerificationNotification();
    
//         return back()->with('message', 'Verification link sent!');
//     })->middleware(['auth', 'throttle:6,1'])->name('customer.verification.send');
// });
// Route::group(['middleware' => ['auth','isAdmin'],'prefix' => 'admin'], function() {//,'verified'
// });
// Route::group(['middleware' => ['auth','isAdmin'],'prefix' => 'admin'], function() {//,'verified'
//     Route::post('/logout')->uses('App\Http\Controllers\Auth\LoginController@logout')->name('admin.logout');
//     Route::get('/dashboard', [DashboardController::class,'index'])->name('admin.dashboard');
//     Route::resource('roles', RoleController::class);
//     //Route::get('/get-roles', [RoleController::class,'getRoles'])->name('get-roles');
//     Route::resource('permissions', PermissionsController::class);
//     Route::get("search",[PermissionsController::class,'index']);
//     Route::resource('users', UserController::class);
//     Route::resource('students', StudentController::class);
//     Route::resource('customers', CustomerController::class);
//     Route::resource('franchises', FranchiseController::class);
//     Route::resource('courses', CourseController::class);
//     Route::resource('studentcourse', StudentCourseController::class,['except' => 'index','create']);
//     Route::get('studentcourses/{student_id}', [StudentCourseController::class,'index'])->name('studentcourses.index');
//     Route::get('studentcourses/create/{student_id}', [StudentCourseController::class,'create'])->name('studentcourses.create');
//     Route::get('/studentcourses/search/{student_id}', [StudentCourseController::class,'autoSeachCourse'])->name('studentcourses.autosearch');
//     Route::get('/student_course/selected', [StudentCourseController::class,'selectedCourse'])->name('student_course.selected');
    
//     Route::get('/autosearch', [AutocompleteController::class, 'selectFranchise'])->name('autosearch');
    
//     // Route::get('/franchises/search', [FranchiseController::class, 'selectSearch']);
//     Route::controller(EbookController::class)->group(function () {
//         Route::get('/ebooks/{course}', 'index')->name('ebooks.index');
//         Route::get('/ebooks/create/{course}', 'create')->name('ebooks.create');
//         Route::post('/ebooks/store', 'store')->name('ebooks.store');
//         Route::get('/ebooks/edit/{id}', 'edit')->name('ebooks.edit');
//         Route::get('/ebooks/show/{id}', 'show')->name('ebooks.show');
//         Route::patch('/ebooks/update/{id}', 'update')->name('ebooks.update');
//         Route::delete('/ebooks/destroy/{id}', 'destroy')->name('ebooks.destroy');
//         Route::get('/ebooks/download/{pdf}', 'download')->name('ebooks.download');
//     });
//     Route::controller(SyllabusController::class)->group(function () {
//         Route::get('/syllabus/{course}', 'show')->name('syllabus.show');
//         Route::get('/syllabus/create/{course}', 'create')->name('syllabus.create');
//         Route::post('/syllabus/store', 'store')->name('syllabus.store');
//         Route::get('/syllabus/edit/{id}', 'edit')->name('syllabus.edit');
//         Route::patch('/syllabus/update/{id}', 'update')->name('syllabus.update');
//     });
//     Route::controller(NotificationController::class)->group(function () {
//         Route::get('/notifications', 'index')->name('notifications.index');
//         Route::get('/notifications/search/customer', 'searchByUser')->name('notifications.searchbycustomer');
//         Route::get('/notifications/create', 'create')->name('notifications.create');
//         Route::post('/notifications/store', 'store')->name('notifications.store');
//         Route::post('/notifications/readall', 'readall')->name('notifications.readall');
//         Route::post('/notifications/destroy/all', 'destroyAll')->name('notifications.destroyall');
//         Route::get('/notifications/view/{id}', 'show')->name('notifications.view');
//         Route::patch('/notifications/read/{id}', 'read')->name('notifications.read');
//         Route::delete('/notifications/destroy/{id}', 'destroy')->name('notifications.destroy');
//     });
//     Route::get('/location', [GeoLocationController::class,'index']);
//     Route::post('/geolocation', [GeoLocationController::class,'getGeocodeFromAPI'])->name('location.search');
   
// });
// Route::group(['middleware' => ['auth','isStudent','verified'],'prefix' => 'student'], function() {//,'verified'
//     Route::get('/dashboard', [StudentDashboardController::class,'index'])->name('student.dashboard');
//     Route::get('/joined/courses', [JoinedCoursesController::class,'index'])->name('student.joinedcourse');
//     Route::get('/joined/courses/view/{course}/{tab}', [JoinedCoursesController::class,'show'])->name('student.courseview');
//     Route::get('/joined/courses/view/ebooks', [JoinedCoursesController::class,'getEbooks'])->name('student.ebooks');
//     Route::get('/joined/courses/view/ebooks/download/{file}', [JoinedCoursesController::class,'download'])->name('student.ebookdownload');
//     Route::get('/profile', [ProfileController::class,'index'])->name('student.profile');
//     Route::post('/change_password/{id}', [ChangePasswordController::class,'changePassword'])->name('student.passwordchange');
//     Route::post('/student-logout')->uses('App\Http\Controllers\Auth\LoginController@logout')->name('student.logout');

// });

// Route::group(['middleware' => ['auth','IsCustomer']], function() {//,'verified'
//     Route::get('/dashboard', [CustomerDashboardController::class,'index'])->name('customer.dashboard');
    

// });
