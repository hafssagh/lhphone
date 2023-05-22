<?php

use App\Http\Livewire\Absences;
use App\Http\Livewire\Historique;
use App\Http\Livewire\Home;
use App\Http\Livewire\Myliste;
use App\Http\Livewire\Users;
use App\Http\Livewire\UserProfile;
use App\Http\Livewire\ResetPassword;
use App\Http\Livewire\Resignations;
use App\Http\Livewire\Salary;
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

/* Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); */

// Le groupe des routes relatives aux administrateurs uniquement
Route::group([
    "middleware" => ["auth", "auth.admin"],
    'as' => 'admin.'
], function () {
    Route::get('/users', Users::class)->name("users.index");
    Route::get('/resignation', Resignations::class)->name("resignation.index");
    Route::get('/history', Historique::class)->name("absence.historique");
    Route::get('/admin/list', Absences::class)->name("absence.index");
    Route::get('/salary', Salary::class)->name("salary");
});


Route::get('/profile/absence', Myliste::class)->name("absence.myliste");
Route::get('/user/change-password', ResetPassword::class)->name("profile.update")->middleware(["auth"]);
Route::get('/profile', UserProfile::class)->name("user.profile")->middleware(["auth"]);
Route::get('/', Home::class)->name("home")->middleware(["auth"]);
