<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TitheController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChurchBudgetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Members
    Route::get('/members', [MemberController::class, 'index'])->name('members.index');
    Route::middleware('admin')->group(function () {
        Route::get('/members/create', [MemberController::class, 'create'])->name('members.create');
        Route::post('/members', [MemberController::class, 'store'])->name('members.store');
        Route::get('/members/{member}/edit', [MemberController::class, 'edit'])->name('members.edit');
        Route::put('/members/{member}', [MemberController::class, 'update'])->name('members.update');
        Route::delete('/members/{member}', [MemberController::class, 'destroy'])->name('members.destroy');
    });
    Route::get('/members/{member}', [MemberController::class, 'show'])->name('members.show');

    // Tithes
    Route::get('/tithes', [TitheController::class, 'index'])->name('tithes.index');
    Route::middleware('staff')->group(function () {
        Route::get('/tithes/create', [TitheController::class, 'create'])->name('tithes.create');
        Route::post('/tithes', [TitheController::class, 'store'])->name('tithes.store');
        Route::get('/tithes/{tithe}/edit', [TitheController::class, 'edit'])->name('tithes.edit');
        Route::put('/tithes/{tithe}', [TitheController::class, 'update'])->name('tithes.update');
    });
    Route::middleware('admin')->delete('/tithes/{tithe}', [TitheController::class, 'destroy'])->name('tithes.destroy');

    // Events
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::middleware('admin')->group(function () {
        Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
        Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    });
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

    // Attendance
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::middleware('staff')->group(function () {
        Route::get('/attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
        Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
        Route::get('/attendance/{attendance}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');
        Route::put('/attendance/{attendance}', [AttendanceController::class, 'update'])->name('attendance.update');
    });
    Route::middleware('admin')->delete('/attendance/{attendance}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');

    // Church Budget — Admin only
    Route::middleware('admin')->group(function () {
        Route::get('/budget', [ChurchBudgetController::class, 'index'])->name('budget.index');
        Route::get('/budget/create', [ChurchBudgetController::class, 'create'])->name('budget.create');
        Route::post('/budget', [ChurchBudgetController::class, 'store'])->name('budget.store');
        Route::get('/budget/{budget}/edit', [ChurchBudgetController::class, 'edit'])->name('budget.edit');
        Route::put('/budget/{budget}', [ChurchBudgetController::class, 'update'])->name('budget.update');
        Route::delete('/budget/{budget}', [ChurchBudgetController::class, 'destroy'])->name('budget.destroy');
    });

    Route::middleware('admin')->group(function () {
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    Route::post('/events/{event}/complete', [EventController::class, 'complete'])->name('events.complete'); // NEW
});

});

require __DIR__.'/auth.php';