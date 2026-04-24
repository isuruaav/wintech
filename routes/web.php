<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\OnlineClassController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\PaperController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Student\ResultController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\OnlineClassController as AdminOnlineClassController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use App\Http\Controllers\Admin\PaperController as AdminPaperController;
use App\Http\Controllers\Admin\DownloadController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\GradeClassAdminController;
use App\Http\Controllers\Admin\TeacherAdminController;
use App\Http\Controllers\Admin\SiteSettingController;

// =====================
// PUBLIC ROUTES
// =====================
Route::get('/',          [HomeController::class, 'index'])->name('home');
Route::get('/courses',   [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
Route::get('/grade-classes',   [GradeController::class, 'index'])->name('grade.index');
Route::get('/grade-classes/{class}', [GradeController::class, 'show'])->name('grade.show');
Route::get('/online-classes',  [OnlineClassController::class, 'index'])->name('online-classes.index');
Route::get('/gallery',         [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/gallery/{album}', [GalleryController::class, 'show'])->name('gallery.show');
Route::get('/videos',          [VideoController::class, 'index'])->name('videos.index');
Route::get('/past-papers',     [PaperController::class, 'papers'])->name('papers.index');
Route::get('/downloads',       [PaperController::class, 'downloads'])->name('downloads.index');
Route::get('/contact',         [ContactController::class, 'index'])->name('contact');
Route::post('/contact',        [ContactController::class, 'store'])->name('contact.store');
Route::get('/search',          [SearchController::class, 'index'])->name('search');

// =====================
// STUDENT AUTH
// =====================
Route::middleware('guest')->group(function () {
    Route::get('/login',  [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    // Registration
    Route::get('/register',  [App\Http\Controllers\Auth\RegisterController::class, 'showForm'])->name('register');
    Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.post');
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// Student Results
Route::get('/results', [App\Http\Controllers\ResultController::class, 'index'])
    ->name('results.index')
    ->middleware('auth');
// =====================
// STUDENT AREA
// =====================
Route::middleware('auth')->prefix('student')->name('student.')->group(function () {
    Route::get('/results', [ResultController::class, 'index'])->name('results');
});

// =====================
// ADMIN AUTH
// =====================
Route::middleware('guest')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/login',  [AdminLoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.post');
});
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// =====================
// ADMIN PANEL
// =====================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Teachers
    Route::get('teachers',                       [TeacherAdminController::class, 'index'])->name('teachers.index');
    Route::get('teachers/create',                [TeacherAdminController::class, 'create'])->name('teachers.create');
    Route::post('teachers',                      [TeacherAdminController::class, 'store'])->name('teachers.store');
    Route::get('teachers/{teacher}/edit',        [TeacherAdminController::class, 'edit'])->name('teachers.edit');
    Route::put('teachers/{teacher}',             [TeacherAdminController::class, 'update'])->name('teachers.update');
    Route::patch('teachers/{teacher}/toggle',    [TeacherAdminController::class, 'toggleStatus'])->name('teachers.toggle');
    Route::delete('teachers/{teacher}',          [TeacherAdminController::class, 'destroy'])->name('teachers.destroy');

    // Grade Classes
    Route::get('classes',                        [GradeClassAdminController::class, 'index'])->name('classes.index');
    Route::get('classes/create',                 [GradeClassAdminController::class, 'create'])->name('classes.create');
    Route::post('classes',                       [GradeClassAdminController::class, 'store'])->name('classes.store');
    Route::get('classes/{class}/edit',           [GradeClassAdminController::class, 'edit'])->name('classes.edit')->whereNumber('class');
    Route::put('classes/{class}',                [GradeClassAdminController::class, 'update'])->name('classes.update')->whereNumber('class');
    Route::patch('classes/{class}/toggle',       [GradeClassAdminController::class, 'toggleStatus'])->name('classes.toggle')->whereNumber('class');
    Route::delete('classes/{class}',             [GradeClassAdminController::class, 'destroy'])->name('classes.destroy')->whereNumber('class');
    Route::post('classes/{class}/schedule',      [GradeClassAdminController::class, 'addSchedule'])->name('classes.schedule.add')->whereNumber('class');
    Route::delete('classes/{class}/schedule/{schedule}', [GradeClassAdminController::class, 'removeSchedule'])->name('classes.schedule.remove')->whereNumber('class');

    // Courses
    Route::resource('courses', AdminCourseController::class)->except(['show']);

    // Students
    Route::resource('students', StudentController::class)->except(['show']);
    Route::post('students/{student}/toggle-active', [StudentController::class, 'toggleActive'])->name('students.toggle-active');
    Route::post('students/{student}/approve',       [StudentController::class, 'approve'])->name('students.approve');
    Route::post('students/{student}/reject',        [StudentController::class, 'reject'])->name('students.reject');

    // Exams & Results
    Route::resource('exams', ExamController::class)->except(['show']);
    Route::get('exams/{exam}/manage',              [ExamController::class, 'manage'])->name('exams.manage');
    Route::post('exams/{exam}/save-results',       [ExamController::class, 'saveResults'])->name('exams.save-results');
    Route::patch('exams/{exam}/toggle-publish',    [ExamController::class, 'togglePublish'])->name('exams.toggle-publish');
    Route::get('exams/{exam}/results',             [App\Http\Controllers\Admin\ResultAdminController::class, 'index'])->name('exams.results');
    Route::post('exams/{exam}/results',            [App\Http\Controllers\Admin\ResultAdminController::class, 'store'])->name('exams.results.store');
    Route::delete('exams/{exam}/results/{result}', [App\Http\Controllers\Admin\ResultAdminController::class, 'destroy'])->name('exams.results.destroy');

    // Online Classes
    Route::resource('online-classes', AdminOnlineClassController::class)->except(['show']);

    // Announcements
    Route::get('announcements',                         [App\Http\Controllers\Admin\AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('announcements/create',                  [App\Http\Controllers\Admin\AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('announcements',                        [App\Http\Controllers\Admin\AnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('announcements/{announcement}/edit',     [App\Http\Controllers\Admin\AnnouncementController::class, 'edit'])->name('announcements.edit');
    Route::put('announcements/{announcement}',          [App\Http\Controllers\Admin\AnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('announcements/{announcement}',       [App\Http\Controllers\Admin\AnnouncementController::class, 'destroy'])->name('announcements.destroy');
    Route::patch('announcements/{announcement}/toggle', [App\Http\Controllers\Admin\AnnouncementController::class, 'toggle'])->name('announcements.toggle');

    // Gallery
    Route::resource('gallery', AdminGalleryController::class)->except(['show']);

    // Videos
    Route::resource('videos', AdminVideoController::class)->except(['show']);

    // Papers
    Route::resource('papers', AdminPaperController::class)->except(['show']);

    // Downloads
    Route::resource('downloads', DownloadController::class)->except(['show']);

    // Enquiries
    Route::resource('enquiries', EnquiryController::class)->only(['index', 'show', 'destroy']);

    Route::get('settings', [SiteSettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SiteSettingController::class, 'update'])->name('settings.update');
});
