<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Jobs\processWelcomeMail;
use App\Mail\WelcomeMail;
use App\Models\Comment;
use App\Models\Phone;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

// Homepage route
Route::get('/', fn() => view('welcome'))->middleware('verified');

// Protected routes with authentication and email verification
Route::middleware(['auth', 'verified'])->group(function () {
    // Blog routes
    Route::prefix('blog')->group(function () {
        Route::get('/', [BlogController::class, 'index'])->name('blog');
        Route::get('/add', [BlogController::class, 'add']);
        Route::post('/create', [BlogController::class, 'create']);
        Route::get('/{id}/show', [BlogController::class, 'show'])->name('detail_blog');
        Route::get('/{id}/edit', [BlogController::class, 'edit']);
        Route::put('/{id}/update', [BlogController::class, 'update']);
        Route::get('/{id}/delete', [BlogController::class, 'delete']);
    });

    // User routes
    Route::get('/user', [UserController::class, 'index']);

    // Comment routes
    Route::post('/comment/{id}', [CommentController::class, 'index'])->name('comment');
    // Route::get('/comment',function (){
    //     return Comment::with('blog')->get();
    // });

    // Logout route
    Route::post('/logout', [AuthController::class, 'AuthLogout'])->name('logout');
});

// Phone route with custom middleware
Route::get('/phone', fn() => Phone::with('user')->get())->middleware('inialias');

// Guest-only routes (for login and registration)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::get('/register', [AuthController::class, 'AuthRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'CreateUser'])->name('register');
    Route::post('/login', [AuthController::class, 'AuthLogin']);

    // Password reset routes
    Route::get('/forgot-password', fn() => view('auth.forgot-password'))->name('password.request');

    Route::post('/forgot-password', function (Request $request) {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($request->only('email'));
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    })->name('password.email');

    Route::get('/reset-password/{token}', fn(string $token) => view('auth.reset-password', ['token' => $token]))
        ->name('password.reset');

    Route::post('/reset-password', function (Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PasswordReset
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    })->middleware('guest')->name('password.update');
});

// File handling routes
Route::get('/upload-image', fn() => view('uploads'));

// Route for showing file metadata
Route::get('/file-show', function () {
    // return asset('storage/example.txt');
    // return Storage::url('example3.pdf');
    // return Storage::get('example3.pdf');
    // return Storage::size('example3.pdf');
    return Storage::lastModified('example3.pdf');
});

// Test email sending
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
        // Mail::to($user['email'])->send(new WelcomeMail($user));
        processWelcomeMail::dispatch($user);
    }
});

// Email verification routes
Route::get('/email/verify', fn() => view('auth.emails'))->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/blog');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
