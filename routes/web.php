<?php

use App\Http\Controllers\auth_controller;
use App\Http\Controllers\budget_controller;
use App\Http\Controllers\change_password_controller;
use App\Http\Controllers\dashboard_controller;
use App\Http\Controllers\faculty_controller;
use App\Http\Controllers\strategic_controller;
use App\Http\Controllers\user_controller;
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

Route::get('/', [auth_controller::class, 'index'])->name('auth.index');
Route::post('/login', [auth_controller::class, 'login'])->name('auth.login');
Route::get('/logout', [auth_controller::class, 'logout'])->name('auth.logout');

Route::get('/dashboard', [dashboard_controller::class, 'index'])->name('dashboard.index');

Route::get('/setting/strategic', [strategic_controller::class, 'index'])->name('setting.strategic.index');
Route::post('/setting/strategic/lists', [strategic_controller::class, 'lists'])->name('setting.strategic.lists');
Route::post('/setting/strategic/store', [strategic_controller::class, 'store'])->name('setting.strategic.store');
Route::post('/setting/strategic/edit', [strategic_controller::class, 'edit'])->name('setting.strategic.edit');
Route::post('/setting/strategic/update', [strategic_controller::class, 'update'])->name('setting.strategic.update');
Route::post('/setting/strategic/destroy', [strategic_controller::class, 'destroy'])->name('setting.strategic.destroy');

Route::get('/setting/faculty', [faculty_controller::class, 'index'])->name('setting.faculty.index');
Route::post('/setting/faculty/lists', [faculty_controller::class, 'lists'])->name('setting.faculty.lists');
Route::post('/setting/faculty/store', [faculty_controller::class, 'store'])->name('setting.faculty.store');
Route::post('/setting/faculty/edit', [faculty_controller::class, 'edit'])->name('setting.faculty.edit');
Route::post('/setting/faculty/update', [faculty_controller::class, 'update'])->name('setting.faculty.update');
Route::post('/setting/faculty/destroy', [faculty_controller::class, 'destroy'])->name('setting.faculty.destroy');


Route::get('/setting/user', [user_controller::class, 'index'])->name('setting.user.index');
Route::post('/setting/user/lists', [user_controller::class, 'lists'])->name('setting.user.lists');
Route::post('/setting/user/store', [user_controller::class, 'store'])->name('setting.user.store');
Route::post('/setting/user/edit', [user_controller::class, 'edit'])->name('setting.user.edit');
Route::post('/setting/user/update', [user_controller::class, 'update'])->name('setting.user.update');
Route::post('/setting/user/destroy', [user_controller::class, 'destroy'])->name('setting.user.destroy');
Route::post('/setting/user/check-username', [user_controller::class, 'check_username'])->name('setting.user.check-username');


Route::get('/setting/budget', [budget_controller::class, 'index'])->name('setting.budget.index');
Route::post('/setting/budget/lists', [budget_controller::class, 'lists'])->name('setting.budget.lists');
Route::post('/setting/budget/store', [budget_controller::class, 'store'])->name('setting.budget.store');
Route::post('/setting/budget/edit', [budget_controller::class, 'edit'])->name('setting.budget.edit');
Route::post('/setting/budget/update', [budget_controller::class, 'update'])->name('setting.budget.update');
Route::post('/setting/budget/destroy', [budget_controller::class, 'destroy'])->name('setting.budget.destroy');

Route::post('/change-password/update', [change_password_controller::class, 'update'])->name('change-password.update');
Route::post('/change-password/check', [change_password_controller::class, 'check'])->name('change-password.check');
