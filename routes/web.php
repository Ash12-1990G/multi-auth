<?php

use App\Http\Controllers\Admin\AutocompleteController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CustomerPaymentController;
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
use App\Http\Controllers\Customer\CustomerLoginController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\FranchiseCourseController;
use App\Http\Controllers\Customer\NotificationController as CustomerNotificationController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Customer\ProfileController as CustomerProfileController;
use App\Http\Controllers\Customer\StudentPaymentController;
use App\Http\Controllers\Student\ContactCenterController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\JoinedCoursesController;
use App\Http\Controllers\Student\Login\StudenLoginController;
use App\Http\Controllers\Student\Notification\NotificationController as StudentNotificationController;
use App\Http\Controllers\Student\ProfileController;
use App\Models\Student;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Admin\ArtisanController;
use App\Http\Controllers\Admin\CustomerFranchiseController;
use App\Http\Controllers\Admin\ReviewController;
use Illuminate\Support\Facades\Artisan;

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
Route::get('/clear', function() {
    Artisan::call('cache:clear');
  Artisan::call('config:clear');
  Artisan::call('config:cache');
  Artisan::call('view:clear');
  Artisan::call('route:clear');


   return "Cleared!";;
});
Route::group(['middleware' => ['guest']], function () {
    Route::post('/password/email')->uses('App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('/password/reset')->uses('App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::get('/password/confirm')->uses('App\Http\Controllers\Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
    Route::post('/password/confirm')->uses('App\Http\Controllers\Auth\ConfirmPasswordController@confirm');
    Route::post('/password/reset')->uses('App\Http\Controllers\Auth\ResetPasswordController@reset')->name('password.update');
    Route::get('/password/reset/{token} ')->uses('App\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('/logout')->uses('App\Http\Controllers\Auth\LoginController@logout')->name('logout');
});

Route::group(['middleware' => ['guest'],'prefix' => 'student'], function () {
    // Authentication Routes...
    Route::get('/login', [StudenLoginController::class,'index'])->name('student.signin');
    Route::post('/login', [StudenLoginController::class,'login'])->name('student.login');
    
    
});

Route::group(['middleware' => ['guest'],'prefix' => 'admin'], function () {
    Route::get('/login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login')->name('admin.loginsubmit');
});

Route::group(['middleware' => ['guest'],'prefix' => 'customer'], function () {
    // Authentication Routes...
    Route::get('/login', [CustomerLoginController::class,'index'])->name('customer.signin');
    Route::post('/login', [CustomerLoginController::class,'login'])->name('customer.login');
    
});

Route::group(['prefix' => 'student'], function () {
    Route::get('/email/verify', function () {
        return view('auth.verify');
    })->middleware('auth')->name('student.verification.notice');
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('student.dashboard');

    })->middleware(['auth', 'signed'])->name('student.verification.verify');
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
    
        return back()->with('message', 'Verification link sent!');
    })->middleware(['auth', 'throttle:6,1'])->name('student.verification.send');
});
Route::group(['prefix' => 'customer'], function () {
    Route::get('/email/verify', function () {
        return view('auth.verify');
    })->middleware('auth')->name('customer.verification.notice');
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('customer.dashboard');

    })->middleware(['auth', 'signed'])->name('customer.verification.verify');
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
    
        return back()->with('message', 'Verification link sent!');
    })->middleware(['auth', 'throttle:6,1'])->name('customer.verification.send');
});

Route::group(['middleware' => ['auth','isAdmin'],'prefix' => 'admin'], function() {
    Route::post('/logout')->uses('App\Http\Controllers\Auth\LoginController@logout')->name('admin.logout');
    Route::get('/changePassword', [DashboardController::class,'passwordChangeView'])->name('admin.changepassword');
    Route::post('/changePassword', [ChangePasswordController::class,'changePassword'])->name('admin.confirmchangepassword');
    Route::get('/dashboard', [DashboardController::class,'index'])->name('admin.dashboard');
    Route::resource('roles', RoleController::class);
    //Route::get('/get-roles', [RoleController::class,'getRoles'])->name('get-roles');
    Route::resource('permissions', PermissionsController::class);
    Route::get("search",[PermissionsController::class,'index']);
    Route::resource('users', UserController::class);
    Route::resource('students', StudentController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('franchises', FranchiseController::class);
    Route::resource('courses', CourseController::class);
    Route::get('/location/check',[CustomerController::class,'checkLocationRadius'])->name('customers.locationcheck');
    Route::get('students/customer/search', [StudentController::class,'customerSearch'])->name('student.customersearch');
    Route::resource('studentcourse', StudentCourseController::class,['except' => 'index','create']);
    Route::get('studentcourses/{student_id}', [StudentCourseController::class,'index'])->name('studentcourses.index');
    Route::get('studentcourses/create/{student_id}', [StudentCourseController::class,'create'])->name('studentcourses.create');
    Route::get('studentcourses/customersearch', [StudentCourseController::class,'searchCustomer'])->name('studentcourses.customersearch');
    Route::get('/studentcourses/search/{student_id}', [StudentCourseController::class,'autoSeachCourse'])->name('studentcourses.autosearch');
    Route::get('/student_course/selected', [StudentCourseController::class,'selectedCourse'])->name('student_course.selected');
    Route::get('/student_courses/{id}/concession', [StudentCourseController::class,'editConcession'])->name('studentcourses.concession');
        Route::put('/student_courses/{id}/concession', [StudentCourseController::class,'updateConcession'])->name('studentcourses.concession.update');
    Route::get('/autosearch', [AutocompleteController::class, 'selectFranchise'])->name('autosearch');
    
    // Route::get('/franchises/search', [FranchiseController::class, 'selectSearch']);
    Route::controller(EbookController::class)->group(function () {
        Route::get('/ebooks/{course}', 'index')->name('ebooks.index');
        Route::get('/ebooks/create/{course}', 'create')->name('ebooks.create');
        Route::post('/ebooks/store', 'store')->name('ebooks.store');
        Route::get('/ebooks/edit/{id}', 'edit')->name('ebooks.edit');
        Route::get('/ebooks/show/{id}', 'show')->name('ebooks.show');
        Route::patch('/ebooks/update/{id}', 'update')->name('ebooks.update');
        Route::delete('/ebooks/destroy/{id}', 'destroy')->name('ebooks.destroy');
        Route::get('/ebooks/download/{pdf}', 'download')->name('ebooks.download');
    });
    Route::controller(SyllabusController::class)->group(function () {
        Route::get('/syllabus/{course}', 'show')->name('syllabus.show');
        Route::get('/syllabus/create/{course}', 'create')->name('syllabus.create');
        Route::post('/syllabus/store', 'store')->name('syllabus.store');
        Route::get('/syllabus/edit/{id}', 'edit')->name('syllabus.edit');
        Route::patch('/syllabus/update/{id}', 'update')->name('syllabus.update');
    });
    Route::controller(CustomerFranchiseController::class)->group(function () {
        Route::get('/customers/franchise/{customer}', 'index')->name('customer_franchise.index');
        Route::get('/customers/franchise/{customer}/create', 'create')->name('customer_franchise.create');
        Route::get('/customers/franchise/{customer}/search', 'autoSeachFranchise')->name('customer_franchise.searchfranchise');
        Route::get('/customers/franchise/{customer}/selected', 'selectedFranchise')->name('customer_franchise.selected');
        Route::get('/customers/franchise/show/{id}', 'show')->name('customer_franchise.show');
        Route::post('/customers/franchise/store', 'store')->name('customer_franchise.store');
        Route::get('/customers/franchise/{customer}/edit/{id}', 'edit')->name('customer_franchise.edit');
        Route::patch('/customers/franchise/update/{id}', 'edit')->name('customer_franchise.update');
        Route::get('/customer/taken_franchise/{id}/concession', 'editConcession')->name('customer_franchise.concession');
        Route::put('/customer/taken_franchise/{id}/concession', 'updateConcession')->name('customer_franchise.concession.update');
        Route::delete('/customers/franchise/destroy/{id}', 'destroy')->name('customer_franchise.destroy');
    });
    Route::controller(CustomerPaymentController::class)->group(function () {
        Route::get('/customers/{customer_franchise}/payment', 'index')->name('customer.payment.index');
        Route::get('/customers/{customer_franchise}/payment/create', 'create')->name('customer.payment.create');
        Route::post('/customer/franchise/payment', 'store')->name('customer.payment.store');
                
        Route::patch('/customer/franchise/payment/{id}', 'update')->name('customer.payment.update');
        Route::delete('/customer/franchise/payment/{id}', 'destroy')->name('customer.payment.destroy');
    });
    Route::controller(NotificationController::class)->group(function () {
        Route::get('/notifications', 'index')->name('notifications.index');
        Route::get('/notifications/sent', 'sentNotification')->name('notifications.sent');
        Route::get('/notifications/sent/{id}/view', 'show')->name('notifications.sent.view');
        Route::get('/notifications/search/customer', 'searchByUser')->name('notifications.searchbycustomer');
        Route::get('/notifications/create', 'create')->name('notifications.create');
        Route::post('/notifications/store', 'store')->name('notifications.store');
        Route::post('/notifications/readall', 'readall')->name('notifications.readall');
        Route::post('/notifications/destroy/all', 'destroyAll')->name('notifications.destroyall');
        Route::get('/notifications/view/{id}', 'show')->name('notifications.view');
        Route::patch('/notifications/read/{id}', 'read')->name('notifications.read');
        Route::delete('/notifications/destroy/{id}', 'destroy')->name('notifications.destroy');
    });
    Route::get('/reviews/{course}', [ReviewController::class,'index'])->name('course.reviews');
    Route::get('/location', [GeoLocationController::class,'index']);
    Route::post('/geolocation', [GeoLocationController::class,'getGeocodeFromAPI'])->name('location.search');
   
});
Route::group(['middleware' => ['auth','isStudent','verified'],'prefix' => 'student'], function() {//,'verified'
    Route::get('/dashboard', [StudentDashboardController::class,'index'])->name('student.dashboard');
    Route::get('/joined/courses', [JoinedCoursesController::class,'index'])->name('student.joinedcourse');
    Route::get('/joined/courses/view/{course}/{tab}', [JoinedCoursesController::class,'show'])->name('student.courseview');
    Route::get('/joined/courses/view/ebooks', [JoinedCoursesController::class,'getEbooks'])->name('student.ebooks');
    Route::get('/joined/courses/view/ebooks/download/{file}', [JoinedCoursesController::class,'download'])->name('student.ebookdownload');
    Route::get('/profile', [ProfileController::class,'index'])->name('student.profile');
    Route::get('/contact-center', [ContactCenterController::class,'index'])->name('student.centers');
    Route::post('/contact-center', [ContactCenterController::class,'sendMail'])->name('student.sendmail');
    Route::controller(StudentNotificationController::class)->group(function () {
        Route::get('/notifications', 'index')->name('student.notifications.index');
        Route::post('/notifications/readall', 'readall')->name('student.notifications.readall');
        Route::post('/notifications/destroy/all', 'destroyAll')->name('student.notifications.destroyall');
        Route::get('/notifications/view/{id}', 'showNotice')->name('student.notifications.view');
        Route::patch('/notifications/read/{id}', 'read')->name('student.notifications.read');
        Route::delete('/notifications/destroy/{notification}/{type}', 'destroy')->name('student.notifications.destroy');
    });
    Route::post('/change_password/{id}', [ChangePasswordController::class,'changePassword'])->name('student.passwordchange');
    Route::post('/student-logout')->uses('App\Http\Controllers\Auth\LoginController@logout')->name('student.logout');

});

Route::group(['middleware' => ['auth','isCustomer','verified'],'prefix' => 'customer'], function() {
    Route::get('/dashboard', [CustomerDashboardController::class,'index'])->name('customer.dashboard');
    Route::post('/customer-logout')->uses('App\Http\Controllers\Auth\LoginController@logout')->name('customer.logout');
    Route::get('/profile',[CustomerProfileController::class,'profile'])->name('customer.profile');
    Route::post('/changepassword',[ChangePasswordController::class,'changePassword'])->name('customer.changepassword');
    Route::controller(FranchiseCourseController::class)->group(function () {
        Route::get('/franchises','franchiseList')->name('customer.franchises');
        Route::get('/franchises/{franchise}','franchiseCourses')->name('customer.course');
        Route::get('/courses/{course}/{tab}','courseView')->name('customer.courseview');
        Route::get('/ebooks','getEbooks')->name('customer.ebooks');
        Route::get('/ebooks/download/{file}','download')->name('customer.ebookdownload');
    });
    Route::controller(CustomerNotificationController::class)->group(function () {
        Route::get('/notifications', 'index')->name('customer.notifications.index');
        Route::get('/notifications/sent', 'sentNotification')->name('customer.notifications.sent');
        Route::get('/notifications/sent/{id}/view', 'show')->name('customer.notifications.sent.view');
        Route::get('/notifications/create', 'create')->name('customer.notifications.create');
        Route::post('/notifications/store', 'store')->name('customer.notifications.store');
        Route::post('/notifications/readall', 'readall')->name('customer.notifications.readall');
        Route::post('/notifications/destroy/all', 'destroyAll')->name('customer.notifications.destroyall');
        Route::get('/notifications/view/{id}', 'showNotice')->name('customer.notifications.view');
        Route::patch('/notifications/read/{id}', 'read')->name('customer.notifications.read');
        Route::delete('/notifications/destroy/{notification}/{type}', 'destroy')->name('customer.notifications.destroy');
    });
    Route::controller(StudentController::class)->group(function () {
        Route::get('/students', 'index')->name('customer.students.index');
        Route::get('/students/create', 'create')->name('customer.students.create');
        Route::post('/students/store', 'store')->name('customer.students.store');
        Route::patch('/students/{id}/edit', 'edit')->name('customer.students.edit');
        Route::patch('/students/{id}', 'update')->name('customer.students.update');
        Route::delete('/students/{id}', 'destroy')->name('customer.students.destroy');
        Route::delete('/students/{id}/show', 'show')->name('customer.students.show');
    });
    Route::controller(StudentCourseController::class)->group(function () {
        Route::get('/studentcourses/{student_id}', 'index')->name('customer.studentcourses.index');
        Route::get('/studentcourses/create/{student_id}', 'create')->name('customer.studentcourses.create');
        Route::post('/studentcourse/store', 'store')->name('customer.studentcourses.store');
        Route::patch('/studentcourse/{id}/edit', 'edit')->name('customer.studentcourses.edit');
        Route::patch('/studentcourse/{id}', 'update')->name('customer.studentcourses.update');
        Route::delete('/studentcourse/{id}', 'destroy')->name('customer.studentcourses.destroy');
        
        Route::get('/studentcourses/customersearch', 'searchCustomer')->name('customer.studentcourses.customersearch');
        Route::get('/studentcourses/search/{student_id}', 'autoSeachCourse')->name('customer.studentcourses.autosearch');
        Route::get('/student_course/selected', 'selectedCourse')->name('customer.student_course.selected');
   
    });
    Route::controller(StudentPaymentController::class)->group(function () {
        Route::get('/payment/{courseid}', 'index')->name('student.payment.index');
        Route::get('/payment/{courseid}/create', 'create')->name('student.payment.create');
        Route::post('/payment/store', 'store')->name('student.payment.store');
        Route::get('/payment/{paymentid}/edit', 'edit')->name('student.payment.edit');
        Route::post('/payment/{paymentid}', 'update')->name('student.payment.update');
        Route::delete('/payment/{paymentid}', 'destroy')->name('student.payment.destroy');
    });
    Route::get('/transactions',[PaymentController::class,'transactionWithAdmin'])->name('customer.transactionwithadmin');

});