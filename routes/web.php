<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Hash;
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

Route::group(['user'], function () {
    Route::get('/masuk', function () {
        return view('masuk');
    })->name('masuk');

    Route::get('/daftar', function () {
        return view('daftar');
    })->name('daftar');

    Route::post('/masuk', [UserController::class, 'masuk'])->name('user.masuk');
    Route::post('/daftar', [UserController::class, 'daftar'])->name('user.daftar');
    Route::post('/keluar', [UserController::class, 'keluar'])->name('user.keluar');

    Route::get('/', function () {
        return view('index');
    })->name('index');

    Route::get('/tentang', function () {
        return view('tentang');
    })->name('tentang');

    Route::get('/cara-pemesanan', function () {
        return view('cara-pemesanan');
    })->name('cara-pemesanan');

    
    Route::get('/booking', [BookingController::class, 'booking'])->name('booking');
    Route::post('/booking/store', [BookingController::class, 'bookingStore'])->name('booking.store');
    Route::patch('/booking/delete={booking_id}', [BookingController::class, 'bookingDelete'])->name('booking.delete');
    Route::patch('/booking/payment', [BookingController::class, 'bookingpayment'])->name('booking.payment');
    
    Route::get('/jadwal', [BookingController::class, 'bookingJadwal'])->name('jadwal');
    
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    });
});

Route::group(['admin'], function () {

    Route::group(['middleware' => 'admin'], function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
        
        Route::get('/admin/user', [AdminController::class, 'user'])->name('admin.user');
        Route::patch('/admin/user/delete/{id}', [AdminController::class, 'userDelete'])->name('admin.user.delete');
        
        Route::get('/admin/pembayaran', [AdminController::class, 'pembayaran'])->name('admin.pembayaran');
        Route::patch('/admin/pembayaran/success/{booking_id}', [AdminController::class, 'pembayaranSuccess'])->name('admin.pembayaran.success');
        Route::patch('/admin/pembayaran/warning/{booking_id}', [AdminController::class, 'pembayaranWarning'])->name('admin.pembayaran.warning');
        
        Route::get('/admin/rekening', [AdminController::class, 'rekening'])->name('admin.rekening');
        Route::post('/admin/rekening/store', [AdminController::class, 'rekeningStore'])->name('admin.rekening.store');
        Route::patch('/admin/rekening/edit', [AdminController::class, 'rekeningEdit'])->name('admin.rekening.edit');
        Route::patch('/admin/rekening/delete/{id}', [AdminController::class, 'rekeningDelete'])->name('admin.rekening.delete');
        
        Route::get('/admin/booking', [AdminController::class, 'booking'])->name('admin.booking');

        Route::get('/admin/lapangan', [AdminController::class, 'lapangan'])->name('admin.lapangan');
        Route::post('/admin/lapangan/store', [AdminController::class, 'lapanganStore'])->name('admin.lapangan.store');
        Route::patch('/admin/lapangan/edit', [AdminController::class, 'lapanganEdit'])->name('admin.lapangan.edit');
        Route::patch('/admin/lapangan/delete/{lapangan_id}', [AdminController::class, 'lapanganDelete'])->name('admin.lapangan.delete');

        Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
    });


    Route::group(['middleware' => 'adminLogin'], function () {
        Route::get('/admin/login', function () {
            
            return view('admin.login');
        })->name('admin.signin');
        Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login');
    });
});
