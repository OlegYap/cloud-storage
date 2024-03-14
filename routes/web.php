<?php
use App\Http\Controllers\FileController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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
    return view('welcome');
});

Route::get('/register', [UserController::class, 'getRegistration'])->name('register');
Route::post('/register', [UserController::class, 'postRegistration'])->name('register');

Route::get('/login', [UserController::class, 'getLogin'])->name('login');
Route::post('/login', [UserController::class, 'postLogin'])->name('login');

Route::get('/signout', [UserController::class, 'signOut'])->name('signout');

Route::get('/main', [MainController::class, 'getMainPage'])->name('main');
Route::post('/main', [FileController::class, 'uploadFile'])->name('main');

Route::get('/download/{file_id}', [FileController::class, 'downloadFile'])->name('download');
Route::get('/view/{file_id}', [FileController::class, 'viewFile'])->name('viewFile');

Route::post('/create',[FolderController::class, 'createFolder'])->name('folder');
Route::get('/viewFolder/{folder_id}', [FolderController::class, 'viewFolder'])->name('viewFolder');
Route::post('uploadFile',[FolderController::class, 'uploadFile'])->name('upload');

Route::post('create/{parent_id}', [FolderController::class, 'createSubfolder'])->name('subFolder');

Route::get('/email/verify', function (){
    return view('verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/login');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
   $request->user()->sendEmailVerificationNotification();
   return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('sendbasicemail',[MailController::class, 'basic_email']);
Route::get('sendhtmlemail',[MailController::class, 'html_email']);
Route::get('sendattachmentemail',[MailController::class, 'attachment_email']);

