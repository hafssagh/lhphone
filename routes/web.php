<?php

use App\Http\Livewire\Home\Home;
use App\Http\Livewire\User\Users;
use App\Http\Livewire\Mail\MailAll;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\Charge\Charges;
use App\Http\Livewire\Mail\SendEmail;
use App\Http\Livewire\Paiment\Salary;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Absence\Myliste;
use App\Http\Livewire\Absence\Absences;
use App\Http\Livewire\Dashboard\DashRH;
use App\Http\Livewire\Dashboard\Suivie;
use App\Http\Livewire\Production\Sales;
use App\Http\Livewire\Dashboard\SuivieH;
use App\Http\Livewire\Dashboard\SuivieV;
use App\Http\Livewire\Explic\MailExplic;
use App\Http\Livewire\Absence\Historique;
use App\Http\Livewire\Production\Produit;
use App\Http\Livewire\Dashboard\Dashboard;
use App\Http\Livewire\Profile\UserProfile;
use App\Http\Livewire\Dashboard\Dashboard2;
use App\Http\Livewire\Paiment\AdvanceSalary;
use App\Http\Livewire\Production\Production;
use App\Http\Livewire\Profile\ResetPassword;
use App\Http\Livewire\Paiment\ChallengePrime;
use App\Http\Livewire\Production\Production2;
use App\Http\Livewire\RelanceAgent\MailAgent;
use App\Http\Livewire\Suspension\Suspensions;
use App\Http\Livewire\Appointment\Appointment;
use App\Http\Livewire\Chat\Messages;
use App\Http\Livewire\Conge\Conge;
use App\Http\Livewire\Dashboard\DashboardAgent;
use App\Http\Livewire\Resignation\Resignations;
use App\Http\Livewire\Dashboard\DashboardAgent2;
use App\Http\Livewire\RelanceManger\MailManager;

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


Route::get('/', Home::class)->name("home")->middleware(["auth"]);
Route::get('/salary', Salary::class)->name("salary");
Route::get('/challenge-prime', ChallengePrime::class)->name("challenge_prime");
Route::get('/advance-salary', AdvanceSalary::class)->name("advance-salary");
Route::get('/admin/list', Absences::class)->name("absence.index");
Route::get('/suspension', Suspensions::class)->name("suspension.index");
Route::get('/resignation', Resignations::class)->name("resignation.index");
Route::get('/history', Historique::class)->name("absence.historique");
Route::get('/users', Users::class)->name("users.index");
Route::get('/dashboard', Dashboard::class)->name("dashboard");
Route::get('/dashboard2', Dashboard2::class)->name("dashboard2");
Route::get('/dashboardRH', DashRH::class)->name("dashRH");
Route::get('/dashboardAgent', DashboardAgent::class)->name("dashAgent");
Route::get('/dashboardAgent2', DashboardAgent2::class)->name("dashAgent2");
Route::get('/dashboardF', Suivie::class)->name("dashboardF");
Route::get('/dashboardV', SuivieV::class)->name("dashboardV");
Route::get('/dashboardH', SuivieH::class)->name("dashboardH");
Route::get('/sales', Sales::class)->name("sales.index");
Route::get('/appointments', Appointment::class)->name("appointment");
Route::get('/fetch', Production::class)->name("production");
Route::get('/fetch2', Production2::class)->name("production2");
Route::get('/production', Produit::class)->name("production2");
Route::get('/profile/absence', Myliste::class)->name("absence.myliste");
Route::get('/user/change-password', ResetPassword::class)->name("profile.update")->middleware(["auth"]);
Route::get('/profile', UserProfile::class)->name("user.profile")->middleware(["auth"]);
Route::get('/customer/proposal', SendEmail::class)->name("mail");
Route::get('/proposal/all', MailAll::class)->name("mailAll");
Route::get('/mailExplic', MailExplic::class)->name("mailExplic");
Route::get('/mailRelance', MailManager::class)->name("RelanceManager");
Route::get('/mailR', MailAgent::class)->name("RelanceAgent");
Route::get('/charges', Charges::class)->name("charge");
Route::get('/chat', Messages::class)->name("message");
Route::get('/conge', Conge::class)->name("conge");
