<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ViewController,
    BencanaController,
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('main.main');
// });

Route::middleware('guest')->group(function () {
    Route::get('/', [ViewController::class, 'index']);
    Route::get('/login', [ViewController::class, 'login'])->name('login');
    Route::post('/login', [ViewController::class, 'authenticate']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ViewController::class, 'dashboard'])->name('dashboard');

    // Routes untuk BencanaController
    Route::get('/databencana', [BencanaController::class, 'index'])->name('bencana.index');
    Route::post('/databencana', [BencanaController::class, 'store'])->name('bencana.store');
    // Route::put('/databencana/{bencana}', [BencanaController::class, 'update'])->name('bencana.update');
    // Route::delete('/databencana/{bencana}', [BencanaController::class, 'destroy'])->name('bencana.destroy');

    // API Routes untuk data bencana (jika diperlukan untuk peta, chart, dll)
    // Route::get('/api/bencana', [BencanaController::class, 'getDataBencana'])->name('api.bencana');
    // Route::get('/api/statistik', [BencanaController::class, 'getStatistik'])->name('api.statistik');

    Route::post('/logout', [ViewController::class, 'logout'])->name('logout');
});

Route::get('/home', function () {
    return redirect('/dashboard');
});
