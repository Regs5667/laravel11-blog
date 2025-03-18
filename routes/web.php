<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureTokenIsValid;
use App\Jobs\processWelcomeMail;
use App\Mail\WelcomeMail;
use App\Models\Comment;
use App\Models\Phone;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', function () {
    return view('welcome');
})->middleware('verified');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/blog', [BlogController::class, 'index'])->name('blog');
    Route::get('/blog/add', [BlogController::class, 'add']);
    Route::post('/blog/create', [BlogController::class, 'create']);
    Route::get('/blog/{id}/show', [BlogController::class, 'show'])->name('detail_blog');
    Route::get('/blog/{id}/edit', [BlogController::class, 'edit']);
    Route::put('/blog/{id}/update', [BlogController::class, 'update']);
    Route::get('/blog/{id}/delete', [BlogController::class, 'delete']);
    Route::get('/user', [UserController::class, 'index']);




    Route::post('/comment/{id}', [CommentController::class, 'index'])->name('comment');
    // Route::get('/comment',function (){
    //     return Comment::with('blog')->get();
    // });
    Route::post('/logout', [AuthController::class, 'AuthLogout'])->name('logout');
});


Route::get('/phone', function () {
    return Phone::with('user')->get();
})->middleware('inialias');
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::get('/register', [AuthController::class, 'AuthRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'CreateUser'])->name('register');
    Route::post('/login', [AuthController::class, 'AuthLogin']);
});





Route::get('/upload-image', function () {
    return view('uploads');
});

// Route::post('/upload-image', function (Request $request) {
//     $file = $request->file('file-test');
//    $ceknama =$file->hashName();
//    $cekext = $file->extension();
//    return $cekext;
//     $path = Storage::putFile('images', $request->file('file-test'));
//     return $path;
// });


Route::get('/file-show', function () {
    // return asset('storage/example.txt');
    // return Storage::url('example3.pdf');
    // return Storage::get('example3.pdf');
    //  return Storage::size('example3.pdf');
    return Storage::lastModified('example3.pdf');
});


Route::get('/test-send', function () {
    $dataList = [
        ['name' => 'Rohmat', 'email' => 'bayu@example.com'],
        ['name' => 'Siti', 'email' => 'siti@example.com'],
        ['name' => 'Budi', 'email' => 'budi@example.com'],
        ['name' => 'Ani', 'email' => 'ani@example.com'],
        ['name' => 'Dika', 'email' => 'dika@example.com'],
        ['name' => 'Lina', 'email' => 'lina@example.com'],
        ['name' => 'Andi', 'email' => 'andi@example.com'],
        ['name' => 'Tina', 'email' => 'tina@example.com'],
        ['name' => 'Faisal', 'email' => 'faisal@example.com'],
        ['name' => 'Nina', 'email' => 'nina@example.com'],
        ['name' => 'Joko', 'email' => 'joko@example.com']
    ];


    foreach ($dataList as $user) {
        //    Mail::to($user['email'])->send(new WelcomeMail($user));
        processWelcomeMail::dispatch($user);
    }
});


Route::get('/email/verify', function () {
    return view('auth.emails');
})->middleware('auth')->name('verification.notice');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/blog');
})->middleware(['auth', 'signed'])->name('verification.verify');


Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
