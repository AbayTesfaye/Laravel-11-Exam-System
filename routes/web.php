<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

// Home route
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Ensure /dashboard only accepts GET requests
Route::view('/dashboard', 'users.dashboard')->name('dashboard');

// Define logout route to accept POST requests
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Define register routes
Route::view('/register', 'auth.register')->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Apply the session check middleware to the login route
Route::middleware(['check.session'])->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);


});

// Define quiz routes
Route::get('/questions/start', [QuestionController::class, 'start'])->name('questions.start');
Route::get('/questions', [QuestionController::class, 'show'])->name('questions.show');
Route::post('/questions/answer', [QuestionController::class, 'answer'])->name('questions.answer');
Route::get('/questions/reset', function () {
    return redirect()->route('quiz.start');
})->name('questions.reset');

// New route to add questions
Route::get('/questions/add', [QuestionController::class, 'create'])->name('questions.create');
Route::post('/questions/add', [QuestionController::class, 'store'])->name('questions.store');

// New routes for viewing and deleting questions
Route::get('/questions/view', [QuestionController::class, 'index'])->name('questions.index');
Route::delete('/questions/{id}', [QuestionController::class, 'destroy'])->name('questions.destroy');

// New route for viewing results
Route::get('/results', [QuestionController::class, 'results'])->name('questions.results');


    // Admin dashboard route
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('users.dashboard');
