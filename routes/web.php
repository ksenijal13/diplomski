<?php

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

Route::get('/', function () {
    return view('pages.login');
});
Route::post("login", "AuthController@login");
Route::get("register", function(){
    return view('pages.register');
});
Route::get("/login", function(){
   return redirect('/');
});
Route::middleware(['user.check'])->group(function () {
    Route::get("/pocetna", "HomeController@index");
    Route::get("/change-study-year/{year}", "UserController@changeStudyYear");
    Route::post("/update-student-info", "UserController@updateUserInfo");
    Route::get("/predmeti", "SubjectController@index");
    Route::get("/godina-predmeti/{godinaId}", "SubjectController@getSubjectsByYear");
    Route::post("/add-subject", "SubjectController@addSubject");
    Route::get("/add-new-exam", "SubjectController@addNewExamDate");
    Route::get("/get-subject-exams", "SubjectController@getSubjectsExams");
    Route::get("/add-new-desc", "SubjectController@addNewDesc");
    Route::get("/add-final-date", "SubjectController@addFinalDate");
    Route::get("/subjects-offset", "SubjectController@getSubjectsWithOffset");
    Route::get("/ocene", "GradesController@index");
    Route::get("/insert-grade", "GradesController@insertGrade");
    Route::get("/grades", "GradesController@getGrades");
    Route::get("/get-subject-grade", "GradesController@getSubjectGrade");
    Route::get("/nastava", "ScheduleController@index");
    Route::get("/write-schedule", "ScheduleController@writeSchedule");
    Route::get("/linkovi", "LinkController@index");
    Route::post("/add-link", "LinkController@addLink");
    Route::get("/get-links", "LinkController@getLinks");
    Route::get("/delete-link", "LinkController@deleteLink");
    Route::get("/delete-schedule", "ScheduleController@deleteSchedule");
});
Route::middleware(['admin.check'])->group(function () {
    Route::get("/admin", "AdminController@index");
    Route::get("/get-users", "UserController@getUsers");
    Route::get("/delete-user", "UserController@deleteUser");
    Route::post("/add-menu-link", "MenuController@addLink");
    Route::get("/delete-menu-link", "MenuController@deleteMenuLink");
    Route::get("/get-menu-links", "MenuController@getMenuLinks");
    Route::post("/update-link", "MenuController@updateMenuLink");
});
Route::post("register-user", "AuthController@register");
Route::get("/logout", "AuthController@logout");
Route::get("/destroy-session", "SubjectController@destroySession");


Route::get("/forget-password", function(){
    return view("pages.forget-password");
});
Route::post("/regain-access", "PhpMailerController@sendEmail");
Route::post('/check-pass', "UserController@checkPassword");
Route::post('/edit-pass', "UserController@editPassword");
Route::get("/edit-password", function(){
    return view("pages.edit-password");
});
