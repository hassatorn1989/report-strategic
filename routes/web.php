<?php

use App\Http\Controllers\auth_controller;
use App\Http\Controllers\budget_controller;
use App\Http\Controllers\change_password_controller;
use App\Http\Controllers\dashboard_controller;
use App\Http\Controllers\faculty_controller;
use App\Http\Controllers\project_type_controller;
use App\Http\Controllers\project_controller;
use App\Http\Controllers\result_analysis_controller;
use App\Http\Controllers\strategic_controller;
use App\Http\Controllers\user_controller;
use App\Http\Controllers\year_controller;
use App\Http\Middleware\AuthCheck;
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

Route::middleware(AuthCheck::class)->group(
    function () {
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

        Route::get('/setting/year', [year_controller::class, 'index'])->name('setting.year.index');
        Route::post('/setting/year/lists', [year_controller::class, 'lists'])->name('setting.year.lists');
        Route::post('/setting/year/store', [year_controller::class, 'store'])->name('setting.year.store');
        Route::post('/setting/year/edit', [year_controller::class, 'edit'])->name('setting.year.edit');
        Route::post('/setting/year/update', [year_controller::class, 'update'])->name('setting.year.update');
        Route::post('/setting/year/destroy', [year_controller::class, 'destroy'])->name('setting.year.destroy');
        Route::post('/setting/year/get-strategic', [year_controller::class, 'get_strategic'])->name('setting.year.get-strategic');
        Route::get('/setting/year/manage-strategic/{id}', [year_controller::class, 'manage_strategic'])->name('setting.year.manage-strategic');
        Route::post('/setting/year/manage-strategic/lists', [year_controller::class, 'manage_strategic_lists'])->name('setting.year.manage-strategic-lists');
        Route::post('/setting/year/manage-strategic/store', [year_controller::class, 'manage_strategic_store'])->name('setting.year.manage-strategic-store');
        Route::post('/setting/year/manage-strategic/check', [year_controller::class, 'manage_strategic_check'])->name('setting.year.manage-strategic-check');
        Route::post('/setting/year/manage-strategic/edit', [year_controller::class, 'manage_strategic_edit'])->name('setting.year.manage-strategic-edit');
        Route::post('/setting/year/manage-strategic/update', [year_controller::class, 'manage_strategic_update'])->name('setting.year.manage-strategic-update');
        Route::post('/setting/year/manage-strategic/destroy', [year_controller::class, 'manage_strategic_destroy'])->name('setting.year.manage-strategic-destroy');


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

        Route::get('/setting/project-type', [project_type_controller::class, 'index'])->name('setting.project-type.index');
        Route::post('/setting/project-type/lists', [project_type_controller::class, 'lists'])->name('setting.project-type.lists');
        Route::post('/setting/project-type/store', [project_type_controller::class, 'store'])->name('setting.project-type.store');
        Route::post('/setting/project-type/edit', [project_type_controller::class, 'edit'])->name('setting.project-type.edit');
        Route::post('/setting/project-type/update', [project_type_controller::class, 'update'])->name('setting.project-type.update');
        Route::post('/setting/project-type/destroy', [project_type_controller::class, 'destroy'])->name('setting.project-type.destroy');

        Route::get('/project', [project_controller::class, 'index'])->name('project.index');
        Route::post('/project/lists', [project_controller::class, 'lists'])->name('project.lists');
        Route::post('/project/store', [project_controller::class, 'store'])->name('project.store');
        Route::post('/project/edit', [project_controller::class, 'edit'])->name('project.edit');
        Route::post('/project/update', [project_controller::class, 'update'])->name('project.update');
        Route::post('/project/destroy', [project_controller::class, 'destroy'])->name('project.destroy');
        Route::get('/project/manage/{id}', [project_controller::class, 'manage'])->name('project.manage');

        Route::get('/result-analysis', [result_analysis_controller::class, 'index'])->name('result-analysis.index');
        Route::post('/result-analysis/store', [result_analysis_controller::class, 'store'])->name('result-analysis.store');
        Route::post('/result-analysis/edit', [result_analysis_controller::class, 'edit'])->name('result-analysis.edit');
        Route::post('/result-analysis/update', [result_analysis_controller::class, 'update'])->name('result-analysis.update');
        Route::post('/result-analysis/destroy', [result_analysis_controller::class, 'destroy'])->name('result-analysis.destroy');

        Route::post('/change-password/update', [change_password_controller::class, 'update'])->name('change-password.update');
        Route::post('/change-password/check', [change_password_controller::class, 'check'])->name('change-password.check');
    }
);
