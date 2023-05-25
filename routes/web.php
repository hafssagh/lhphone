<?php

use App\Http\Livewire\Home\Home;
use App\Http\Livewire\Production\Sales;
use App\Http\Livewire\User\Users;
use App\Http\Livewire\Salary\Salary;
use App\Http\Livewire\Absence\Myliste;
use App\Http\Livewire\Absence\Absences;
use App\Http\Livewire\Absence\Historique;
use App\Http\Livewire\Production\Production;
use App\Http\Livewire\Profile\UserProfile;
use App\Http\Livewire\Resignation\Resignations;
use App\Http\Livewire\Profile\ResetPassword;
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



Route::get('/sales', Sales::class)->name("sales.index");
Route::get('/production', Production::class)->name("production");
Route::get('/profile/absence', Myliste::class)->name("absence.myliste");
Route::get('/user/change-password', ResetPassword::class)->name("profile.update")->middleware(["auth"]);
Route::get('/profile', UserProfile::class)->name("user.profile")->middleware(["auth"]);
Route::get('/', Home::class)->name("home")->middleware(["auth"]);
