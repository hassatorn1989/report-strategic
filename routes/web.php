<?php

use App\Http\Controllers\auth_controller;
use App\Http\Controllers\budget_controller;
use App\Http\Controllers\change_password_controller;
use App\Http\Controllers\dashboard_controller;
use App\Http\Controllers\driven_controller;
use App\Http\Controllers\faculty_controller;
use App\Http\Controllers\home_controller;
use App\Http\Controllers\project_type_controller;
use App\Http\Controllers\project_sub_type_controller;
use App\Http\Controllers\project_controller;
use App\Http\Controllers\project_main_controller;
use App\Http\Controllers\project_main_type_controller;
use App\Http\Controllers\report\report_project_controller;
use App\Http\Controllers\report\report_project_stractegic_controller;
use App\Http\Controllers\result_analysis_controller;
use App\Http\Controllers\strategic_controller;
use App\Http\Controllers\test_controller;
use App\Http\Controllers\user_controller;
use App\Http\Controllers\work_controller;
use App\Http\Controllers\year_controller;
use App\Http\Controllers\check_project_controller;
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

Route::get('/', [home_controller::class, 'index'])->name('home.index');
Route::post('/home/get-project', [home_controller::class, 'get_project'])->name('home.get-project');
Route::post('/home/get-project-detail', [home_controller::class, 'get_project_detail'])->name('home.get-project-detail');


Route::get('/report/project-stractegic', [report_project_stractegic_controller::class, 'index'])->name('report.project-stractegic');
Route::post('/report/project-stractegic/lists', [report_project_stractegic_controller::class, 'lists'])->name('report.project-stractegic.lists');

Route::get('/report/project', [report_project_controller::class, 'index'])->name('report.project');
Route::post('/report/project/lists', [report_project_controller::class, 'lists'])->name('report.project.lists');


Route::get('/signin', [auth_controller::class, 'index'])->name('auth.index');
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

        Route::get('/setting/year/manage-sub-strategic/{id}', [year_controller::class, 'manage_sub_strategic'])->name('setting.year.manage-sub-strategic');
        Route::post('/setting/year/manage-sub-strategic/lists', [year_controller::class, 'manage_sub_strategic_lists'])->name('setting.year.manage-sub-strategic-lists');
        Route::post('/setting/year/manage-sub-strategic/store', [year_controller::class, 'manage_sub_strategic_store'])->name('setting.year.manage-sub-strategic-store');
        Route::post('/setting/year/manage-sub-strategic/edit', [year_controller::class, 'manage_sub_strategic_edit'])->name('setting.year.manage-sub-strategic-edit');
        Route::post('/setting/year/manage-sub-strategic/update', [year_controller::class, 'manage_sub_strategic_update'])->name('setting.year.manage-sub-strategic-update');
        Route::post('/setting/year/manage-sub-strategic/destroy', [year_controller::class, 'manage_sub_strategic_destroy'])->name('setting.year.manage-sub-strategic-destroy');


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

        Route::get('/setting/project-sub-type', [project_sub_type_controller::class, 'index'])->name('setting.project-sub-type.index');
        Route::post('/setting/project-sub-type/lists', [project_sub_type_controller::class, 'lists'])->name('setting.project-sub-type.lists');
        Route::post('/setting/project-sub-type/store', [project_sub_type_controller::class, 'store'])->name('setting.project-sub-type.store');
        Route::post('/setting/project-sub-type/edit', [project_sub_type_controller::class, 'edit'])->name('setting.project-sub-type.edit');
        Route::post('/setting/project-sub-type/update', [project_sub_type_controller::class, 'update'])->name('setting.project-sub-type.update');
        Route::post('/setting/project-sub-type/destroy', [project_sub_type_controller::class, 'destroy'])->name('setting.project-sub-type.destroy');

        Route::get('/setting-project/project-main-type', [project_main_type_controller::class, 'index'])->name('setting-project.project-main-type.index');
        Route::post('/setting-project/project-main-type/lists', [project_main_type_controller::class, 'lists'])->name('setting-project.project-main-type.lists');
        Route::post('/setting-project/project-main-type/store', [project_main_type_controller::class, 'store'])->name('setting-project.project-main-type.store');
        Route::post('/setting-project/project-main-type/edit', [project_main_type_controller::class, 'edit'])->name('setting-project.project-main-type.edit');
        Route::post('/setting-project/project-main-type/update', [project_main_type_controller::class, 'update'])->name('setting-project.project-main-type.update');
        Route::post('/setting-project/project-main-type/destroy', [project_main_type_controller::class, 'destroy'])->name('setting-project.project-main-type.destroy');

        Route::get('/setting-project/project-main', [project_main_controller::class, 'index'])->name('setting-project.project-main.index');
        Route::post('/setting-project/project-main/lists', [project_main_controller::class, 'lists'])->name('setting-project.project-main.lists');
        Route::post('/setting-project/project-main/store', [project_main_controller::class, 'store'])->name('setting-project.project-main.store');
        Route::post('/setting-project/project-main/edit', [project_main_controller::class, 'edit'])->name('setting-project.project-main.edit');
        Route::post('/setting-project/project-main/update', [project_main_controller::class, 'update'])->name('setting-project.project-main.update');
        Route::post('/setting-project/project-main/destroy', [project_main_controller::class, 'destroy'])->name('setting-project.project-main.destroy');
        Route::post('/setting-project/project-main/get-faculty', [project_main_controller::class, 'get_faculty'])->name('setting-project.project-main.get-faculty');
        Route::post('/setting-project/project-main/check-budget', [project_main_controller::class, 'check_budget'])->name('setting-project.project-main.check-budget');

        Route::get('/setting-project/project/{id}', [project_controller::class, 'index'])->name('project.index');
        Route::post('/setting-project/project/lists', [project_controller::class, 'lists'])->name('project.lists');
        Route::post('/setting-project/project/store', [project_controller::class, 'store'])->name('project.store');
        Route::post('/setting-project/project/edit', [project_controller::class, 'edit'])->name('project.edit');
        Route::post('/setting-project/project/update', [project_controller::class, 'update'])->name('project.update');
        Route::post('/setting-project/project/destroy', [project_controller::class, 'destroy'])->name('project.destroy');


        Route::post('/setting-project/project/manage/responsible-person-store', [project_controller::class, 'manage_responsible_person_store'])->name('project.manage.responsible-person-store');
        Route::post('/setting-project/project/manage/responsible-person-edit', [project_controller::class, 'manage_responsible_person_edit'])->name('project.manage.responsible-person-edit');
        Route::post('/setting-project/project/manage/responsible-person-update', [project_controller::class, 'manage_responsible_person_update'])->name('project.manage.responsible-person-update');
        Route::post('/setting-project/project/manage/responsible-person-destroy', [project_controller::class, 'manage_responsible_person_destroy'])->name('project.manage.responsible-person-destroy');

        Route::post('/setting-project/project/manage/target-group-store', [project_controller::class, 'manage_target_group_store'])->name('project.manage.target-group-store');
        Route::post('/setting-project/project/manage/target-group-edit', [project_controller::class, 'manage_target_group_edit'])->name('project.manage.target-group-edit');
        Route::post('/setting-project/project/manage/target-group-update', [project_controller::class, 'manage_target_group_update'])->name('project.manage.target-group-update');
        Route::post('/setting-project/project/manage/target-group-destroy', [project_controller::class, 'manage_target_group_destroy'])->name('project.manage.target-group-destroy');

        Route::post('/setting-project/project/manage/problem-store', [project_controller::class, 'manage_problem_store'])->name('project.manage.problem-store');
        Route::post('/setting-project/project/manage/problem-edit', [project_controller::class, 'manage_problem_edit'])->name('project.manage.problem-edit');
        Route::post('/setting-project/project/manage/problem-update', [project_controller::class, 'manage_problem_update'])->name('project.manage.problem-update');
        Route::post('/setting-project/project/manage/problem-destroy', [project_controller::class, 'manage_problem_destroy'])->name('project.manage.problem-destroy');

        Route::post('/setting-project/project/manage/get-problem-summary', [project_controller::class, 'manage_get_problem_summary'])->name('project.manage.get-problem-summary');
        Route::post('/setting-project/project/manage/get-problem-summary-update', [project_controller::class, 'manage_problem_summary_update'])->name('project.manage.get-problem-summary-update');


        Route::get('/setting-project/project/manage/{id}', [project_controller::class, 'manage'])->name('project.manage');
        Route::post('/setting-project/project/manage/check-publish', [project_controller::class, 'check_publish'])->name('project.manage.check-publish');
        Route::post('/setting-project/project/manage/publish', [project_controller::class, 'publish'])->name('project.manage.publish');


        Route::post('/setting-project/project/manage/problem-solution-store', [project_controller::class, 'manage_problem_solution_store'])->name('project.manage.problem-solution-store');
        Route::post('/setting-project/project/manage/problem-solution-edit', [project_controller::class, 'manage_problem_solution_edit'])->name('project.manage.problem-solution-edit');
        Route::post('/setting-project/project/manage/problem-solution-update', [project_controller::class, 'manage_problem_solution_update'])->name('project.manage.problem-solution-update');
        Route::post('/setting-project/project/manage/problem-solution-destroy', [project_controller::class, 'manage_problem_solution_destroy'])->name('project.manage.problem-solution-destroy');
        Route::post('/setting-project/project/manage/get-problem-solution-summary', [project_controller::class, 'manage_get_problem_solution_summary'])->name('project.manage.get-problem-solution-summary');
        Route::post('/setting-project/project/manage/get-problem-solution-summary-update', [project_controller::class, 'manage_problem_solution_summary_update'])->name('project.manage.get-problem-solution-summary-update');

        Route::post('/setting-project/project/manage/quantitative-indicators-store', [project_controller::class, 'manage_quantitative_indicators_store'])->name('project.manage.quantitative-indicators-store');
        Route::post('/setting-project/project/manage/quantitative-indicators-edit', [project_controller::class, 'manage_quantitative_indicators_edit'])->name('project.manage.quantitative-indicators-edit');
        Route::post('/setting-project/project/manage/quantitative-indicators-update', [project_controller::class, 'manage_quantitative_indicators_update'])->name('project.manage.quantitative-indicators-update');
        Route::post('/setting-project/project/manage/quantitative-indicators-destroy', [project_controller::class, 'manage_quantitative_indicators_destroy'])->name('project.manage.quantitative-indicators-destroy');

        Route::post('/setting-project/project/manage/qualitative-indicators-store', [project_controller::class, 'manage_qualitative_indicators_store'])->name('project.manage.qualitative-indicators-store');
        Route::post('/setting-project/project/manage/qualitative-indicators-edit', [project_controller::class, 'manage_qualitative_indicators_edit'])->name('project.manage.qualitative-indicators-edit');
        Route::post('/setting-project/project/manage/qualitative-indicators-update', [project_controller::class, 'manage_qualitative_indicators_update'])->name('project.manage.qualitative-indicators-update');
        Route::post('/setting-project/project/manage/qualitative-indicators-destroy', [project_controller::class, 'manage_qualitative_indicators_destroy'])->name('project.manage.qualitative-indicators-destroy');

        Route::post('/setting-project/project/manage/output-store', [project_controller::class, 'manage_output_store'])->name('project.manage.output-store');
        Route::post('/setting-project/project/manage/output-edit', [project_controller::class, 'manage_output_edit'])->name('project.manage.output-edit');
        Route::post('/setting-project/project/manage/output-update', [project_controller::class, 'manage_output_update'])->name('project.manage.output-update');
        Route::post('/setting-project/project/manage/output-destroy', [project_controller::class, 'manage_output_destroy'])->name('project.manage.output-destroy');
        Route::post('/setting-project/project/manage/output-gallery-store', [project_controller::class, 'manage_output_gallery_store'])->name('project.manage.output-gallery-store');
        Route::post('/setting-project/project/manage/output-gallery-show', [project_controller::class, 'manage_output_gallery_show'])->name('project.manage.output-gallery-show');
        Route::post('/setting-project/project/manage/output-gallery-destroy', [project_controller::class, 'manage_output_gallery_destroy'])->name('project.manage.output-gallery-destroy');

        Route::post('/setting-project/project/manage/get-project-indicators', [project_controller::class, 'get_project_indicators'])->name('project.manage.get-project-indicators');

        Route::post('/setting-project/project/manage/outcome-store', [project_controller::class, 'manage_outcome_store'])->name('project.manage.outcome-store');
        Route::post('/setting-project/project/manage/outcome-edit', [project_controller::class, 'manage_outcome_edit'])->name('project.manage.outcome-edit');
        Route::post('/setting-project/project/manage/outcome-update', [project_controller::class, 'manage_outcome_update'])->name('project.manage.outcome-update');
        Route::post('/setting-project/project/manage/outcome-destroy', [project_controller::class, 'manage_outcome_destroy'])->name('project.manage.outcome-destroy');

        Route::post('/setting-project/project/manage/impact-store', [project_controller::class, 'manage_impact_store'])->name('project.manage.impact-store');
        Route::post('/setting-project/project/manage/impact-edit', [project_controller::class, 'manage_impact_edit'])->name('project.manage.impact-edit');
        Route::post('/setting-project/project/manage/impact-update', [project_controller::class, 'manage_impact_update'])->name('project.manage.impact-update');
        Route::post('/setting-project/project/manage/impact-destroy', [project_controller::class, 'manage_impact_destroy'])->name('project.manage.impact-destroy');


        Route::post('/setting-project/project/manage/output-detail-store', [project_controller::class, 'manage_output_detail_store'])->name('project.manage.output-detail-store');
        Route::post('/setting-project/project/manage/output-detail-edit', [project_controller::class, 'manage_output_detail_edit'])->name('project.manage.output-detail-edit');
        Route::post('/setting-project/project/manage/output-detail-update', [project_controller::class, 'manage_output_detail_update'])->name('project.manage.output-detail-update');
        Route::post('/setting-project/project/manage/output-detail-destroy', [project_controller::class, 'manage_output_detail_destroy'])->name('project.manage.output-detail-destroy');


        Route::post('/setting-project/project/manage/location-store', [project_controller::class, 'manage_location_store'])->name('project.manage.location-store');
        Route::post('/setting-project/project/manage/location-edit', [project_controller::class, 'manage_location_edit'])->name('project.manage.location-edit');
        Route::post('/setting-project/project/manage/location-update', [project_controller::class, 'manage_location_update'])->name('project.manage.location-update');
        Route::post('/setting-project/project/manage/location-destroy', [project_controller::class, 'manage_location_destroy'])->name('project.manage.location-destroy');
        Route::post('/setting-project/project/manage/get-location-district', [project_controller::class, 'get_location_district'])->name('project.manage.get-location-district');
        Route::post('/setting-project/project/manage/get-location-subdistrict', [project_controller::class, 'get_location_subdistrict'])->name('project.manage.get-location-subdistrict');
        Route::post('/setting-project/project/manage/get-location-village', [project_controller::class, 'get_location_village'])->name('project.manage.get-location-village');


        Route::post('/setting-project/project/manage/file-store', [project_controller::class, 'manage_file_store'])->name('project.manage.file-store');
        Route::post('/setting-project/project/manage/file-destroy', [project_controller::class, 'manage_file_destroy'])->name('project.manage.file-destroy');



        Route::get('/check-project', [check_project_controller::class, 'index'])->name('check-project.index');
        Route::post('/check-project/lists', [check_project_controller::class, 'lists'])->name('check-project.lists');
        Route::post('/check-project/update', [check_project_controller::class, 'update'])->name('check-project.update');
        Route::get('/check-project/detail/{id}', [check_project_controller::class, 'detail'])->name('check-project.detail');
        

        Route::get('/result-analysis', [result_analysis_controller::class, 'index'])->name('result-analysis.index');
        Route::post('/result-analysis/store', [result_analysis_controller::class, 'store'])->name('result-analysis.store');
        Route::post('/result-analysis/edit', [result_analysis_controller::class, 'edit'])->name('result-analysis.edit');
        Route::post('/result-analysis/update', [result_analysis_controller::class, 'update'])->name('result-analysis.update');
        Route::post('/result-analysis/destroy', [result_analysis_controller::class, 'destroy'])->name('result-analysis.destroy');

        Route::get('/work', [work_controller::class, 'index'])->name('work.index');
        Route::post('/work/store', [work_controller::class, 'store'])->name('work.store');
        Route::post('/work/edit', [work_controller::class, 'edit'])->name('work.edit');
        Route::post('/work/update', [work_controller::class, 'update'])->name('work.update');
        Route::post('/work/destroy', [work_controller::class, 'destroy'])->name('work.destroy');

        Route::get('/driven', [driven_controller::class, 'index'])->name('driven.index');
        Route::post('/driven/store', [driven_controller::class, 'store'])->name('driven.store');
        Route::post('/driven/edit', [driven_controller::class, 'edit'])->name('driven.edit');
        Route::post('/driven/update', [driven_controller::class, 'update'])->name('driven.update');
        Route::post('/driven/destroy', [driven_controller::class, 'destroy'])->name('driven.destroy');

        Route::post('/change-password/update', [change_password_controller::class, 'update'])->name('change-password.update');
        Route::post('/change-password/check', [change_password_controller::class, 'check'])->name('change-password.check');
    }
);

Route::get('/test', [test_controller::class, 'index'])->name('test.index');
