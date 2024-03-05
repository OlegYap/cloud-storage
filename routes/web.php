<?php
use App\Http\Controllers\FileController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
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

Route::get('/download/{user_id}/{file_id}', [FileController::class, 'downloadFile'])->name('download');
Route::get('/view/{user_id}/{file_id}', [FileController::class, 'viewFile'])->name('viewFile');

Route::post('/create',[FolderController::class, 'createFolder'])->name('folder');
Route::get('/viewFolder/{user_id}/{folder_id}', [FolderController::class, 'viewFolder'])->name('viewFolder');
Route::post('uploadFile',[FolderController::class, 'uploadFile'])->name('upload');
Route::get('getFile/{folder_id}', [FolderController::class, 'getFile'])->name('getFile');


Route::get('sendbasicemail',[\App\Http\Controllers\MailController::class, 'basic_email']);
/*Route::get('sendhtmlemail','MailController@html_email');
Route::get('sendattachmentemail','MailController@attachment_email');*/
