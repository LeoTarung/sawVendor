<?php

use App\Models\KriteriaModel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\AuthController;
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

Route::get('/login', [AuthController::class, 'tampilanLogin'])->name('login');
Route::post('/login/masuk', [AuthController::class, 'Login'])->name('proses_login');
Route::get('/daftar', [AuthController::class, 'tampilanDaftar']);
Route::post('/daftar', [AuthController::class, 'daftar']);
Route::get('forgot-password', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [AuthController::class, 'sendResetLink'])->name('password.update');

// Route::get('/', function () {
//     return view('home');
// });
Route::get('/', [KriteriaController::class, 'home'])->middleware('auth')->name('home');

Route::get('/kriteria', [KriteriaController::class, 'index'])->middleware('auth')->name('kriteria');
Route::get('/partial/modal/notes/{id}', [KriteriaController::class, 'indexModalNotes'])->middleware('auth')->name('kriteria');
Route::post('/kriteria/tambah', [KriteriaController::class, 'tambahKriteria'])->middleware('auth');
Route::get('/kriteria/edit/{kode}', [KriteriaController::class, 'editkriteria'])->middleware('auth');
Route::post('/kriteria/edit', [KriteriaController::class, 'updateKriteria'])->middleware('auth');
Route::post('/save/notes/{id}', [KriteriaController::class, 'saveNotes'])->middleware('auth');
Route::post('/update/notes/{id}', [KriteriaController::class, 'saveNotes'])->middleware('auth');
Route::post('/validasi/kriteria/{id}', [KriteriaController::class, 'validasi'])->middleware('auth');
Route::delete('/kriteria/{kode}', [KriteriaController::class, 'destroy'])->middleware('auth');

Route::get('/alternatif', [AlternativeController::class, 'index'])->middleware('auth')->name('alternatif');
Route::post('/alternatif/tambah', [AlternativeController::class, 'tambahAlternatif'])->middleware('auth');
Route::get('/alternatif/edit/{kode}', [AlternativeController::class, 'editAlternatif'])->middleware('auth');
Route::post('/alternatif/edit', [ALternativeController::class, 'updateAlternatif'])->middleware('auth');
Route::delete('/alternatif/{kode}', [AlternativeController::class, 'destroy'])->middleware('auth');

Route::get('/subKriteria', [KriteriaController::class, 'indexSub'])->middleware('auth')->name('kriteria');
Route::post('/subKriteria/tambah/{i}', [KriteriaController::class, 'tambahSub'])->middleware('auth')->name('tambahSub');
Route::get('/subKriteria/edit/{id}', [KriteriaController::class, 'editsubKriteria'])->middleware('auth');
Route::post('/subKriteria/update', [KriteriaController::class, 'updateSubKriteria'])->middleware('auth');
Route::delete('/subKriteria/{id}', [KriteriaController::class, 'destroySub'])->middleware('auth');


Route::get('/penilaian', [PenilaianController::class, 'index'])->middleware('auth');
Route::post('/penilaian/tambah', [PenilaianController::class, 'tambahPenilaian'])->middleware('auth');
Route::get('/penilaian/edit/{alternatif}', [PenilaianController::class, 'editPenilaian'])->middleware('auth');;
Route::post('/penilaian/Edit', [PenilaianController::class, 'updatePenilaian'])->middleware('auth');

Route::get('/perhitungan', [PenilaianController::class, 'indexPerhitungan'])->middleware('auth');

Route::get('/hasil', [PenilaianController::class, 'hasil']);

Route::get('/print', [PenilaianController::class, 'indexPrint'])->name('print');
