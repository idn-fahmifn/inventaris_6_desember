<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// route admin
Route::prefix('admin')->middleware(['auth', 'verified', 'admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    Route::get('/list-petugas', [ProfileController::class, 'index'])->name('petugas.index');
    Route::post('/simpan-petugas', [ProfileController::class, 'store'])->name('petugas.store');

    // crud ruangan
    Route::resource('room', RoomController::class);
    Route::resource('item', ItemController::class);


});

Route::prefix('user')->middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'dashboardUser'])->name('dashboard.user');

    // melihat data ruangan petugas
    // edit data barang miliknya.

    Route::get('room', [RoomController::class, 'indexPetugas'])->name('petugas.index.room');
    Route::get('room/{param}', [RoomController::class, 'showPetugas'])->name('petugas.show.room');

    Route::get('item/{param}', [ItemController::class, 'showPetugas'])->name('petugas.show.item');
    Route::put('item/{param}', [ItemController::class, 'updatePetugas'])->name('petugas.update.item');


});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
