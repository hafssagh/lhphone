<?php

use App\Http\Livewire\Absences;
use App\Http\Livewire\Historique;
use App\Http\Livewire\Myliste;
use App\Http\Livewire\Users;
use App\Http\Livewire\UserProfile;
use App\Http\Livewire\ResetPassword;
use App\Http\Livewire\Resignations;
use App\Http\Livewire\Test;
use Illuminate\Support\Facades\Auth;
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


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Le groupe des routes relatives aux administrateurs uniquement
Route::group([
    "middleware" => ["auth", "auth.admin"],
    'as' => 'admin.'
], function () {
    Route::get('/users', Users::class)->name("users.index");
    Route::get('/resignation', Resignations::class)->name("resignation.index");
    Route::get('/history', Historique::class)->name("absence.historique");
    Route::get('/absence', Absences::class)->name("absence.index");
});


Route::get('/Myabsence', Myliste::class)->name("absence.myliste");
Route::get('/change-password', ResetPassword::class)->name("profile.update")->middleware(["auth"]);
Route::get('/user-profile', UserProfile::class)->name("user.profile")->middleware(["auth"]);
