<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsPublicController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\GalleryVideoPublicController;
use App\Http\Controllers\GalleryPhotoPublicController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\NewsCategoryController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\GreetingController;
use App\Http\Controllers\Admin\DownloadController;
use App\Http\Controllers\DownloadCenterController;
use App\Http\Controllers\Admin\DatabaseBackupController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/pimpinan', [HomeController::class, 'pimpinan'])->name('pimpinan');
Route::get('/news', [NewsPublicController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsPublicController::class, 'show'])->name('news.show');
Route::get('/category/{slug}', [NewsPublicController::class, 'category'])->name('news.category');
Route::get('/gallery/photo', [GalleryPhotoPublicController::class, 'index'])->name('gallery.photo');
Route::get('/gallery/video', [GalleryVideoPublicController::class, 'index'])->name('gallery.video');

// Academic Calendar
Route::get('/academic-calendar', function () {
    return view('frontend.academic-calendar');
})->name('academic-calendar');

// Download Center
Route::get('/downloads', [DownloadCenterController::class, 'index'])->name('downloads.index');
Route::get('/downloads/{download}/download', [DownloadCenterController::class, 'download'])->name('downloads.download');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('menus', MenuController::class);
    Route::post('/menus/reorder', [MenuController::class, 'reorder'])->name('menus.reorder');
    Route::resource('news-categories', NewsCategoryController::class)->parameters(['news-categories'=>'id']);
    Route::delete('news/bulk-delete', [NewsController::class, 'bulkDelete'])->name('news.bulk-delete');
    Route::resource('news', NewsController::class);
    Route::resource('settings', SettingController::class)->only(['index','edit','update']);
    Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);
    Route::resource('sliders', \App\Http\Controllers\Admin\SliderController::class);
    Route::resource('gallery-photos', \App\Http\Controllers\Admin\GalleryPhotoController::class);
    Route::resource('gallery-videos', \App\Http\Controllers\Admin\GalleryVideoController::class);
    
    // Agendas
    Route::post('agendas/update-settings', [AgendaController::class, 'updateSettings'])->name('agendas.update-settings');
    Route::resource('agendas', AgendaController::class);
    
    // Announcements
    Route::post('announcements/update-settings', [AnnouncementController::class, 'updateSettings'])->name('announcements.update-settings');
    Route::resource('announcements', AnnouncementController::class);
    
    Route::resource('greetings', GreetingController::class);
    
    // Download Center
    Route::resource('downloads', DownloadController::class);
    
    // Footer Management
    Route::get('footer', [\App\Http\Controllers\Admin\FooterController::class, 'index'])->name('footer.index');
    Route::get('footer/sections/create', [\App\Http\Controllers\Admin\FooterController::class, 'createSection'])->name('footer.sections.create');
    Route::post('footer/sections', [\App\Http\Controllers\Admin\FooterController::class, 'storeSection'])->name('footer.sections.store');
    Route::get('footer/sections/{section}/edit', [\App\Http\Controllers\Admin\FooterController::class, 'editSection'])->name('footer.sections.edit');
    Route::put('footer/sections/{section}', [\App\Http\Controllers\Admin\FooterController::class, 'updateSection'])->name('footer.sections.update');
    Route::delete('footer/sections/{section}', [\App\Http\Controllers\Admin\FooterController::class, 'destroySection'])->name('footer.sections.destroy');
    Route::get('footer/sections/{section}/links/create', [\App\Http\Controllers\Admin\FooterController::class, 'createLink'])->name('footer.links.create');
    Route::post('footer/sections/{section}/links', [\App\Http\Controllers\Admin\FooterController::class, 'storeLink'])->name('footer.links.store');
    Route::get('footer/links/{link}/edit', [\App\Http\Controllers\Admin\FooterController::class, 'editLink'])->name('footer.links.edit');
    Route::put('footer/links/{link}', [\App\Http\Controllers\Admin\FooterController::class, 'updateLink'])->name('footer.links.update');
    Route::delete('footer/links/{link}', [\App\Http\Controllers\Admin\FooterController::class, 'destroyLink'])->name('footer.links.destroy');
    
    // Theme Management
    Route::get('theme', [\App\Http\Controllers\Admin\ThemeController::class, 'index'])->name('theme.index');
    Route::put('theme', [\App\Http\Controllers\Admin\ThemeController::class, 'update'])->name('theme.update');
    Route::post('theme/reset', [\App\Http\Controllers\Admin\ThemeController::class, 'reset'])->name('theme.reset');
    
    // Database Backup
    Route::get('backup', [DatabaseBackupController::class, 'index'])->name('backup.index');
    Route::post('backup/create', [DatabaseBackupController::class, 'create'])->name('backup.create');
    Route::get('backup/download/{filename}', [DatabaseBackupController::class, 'download'])->name('backup.download');
    Route::delete('backup/destroy/{filename}', [DatabaseBackupController::class, 'destroy'])->name('backup.destroy');
    
    // Why Choose Us
    Route::post('why-choose-us/update-settings', [\App\Http\Controllers\Admin\WhyChooseUsController::class, 'updateSettings'])->name('why-choose-us.update-settings');
    Route::resource('why-choose-us', \App\Http\Controllers\Admin\WhyChooseUsController::class)->parameters([
        'why-choose-us' => 'whyChooseUs'
    ]);
    Route::post('why-choose-us/reorder', [\App\Http\Controllers\Admin\WhyChooseUsController::class, 'reorder'])->name('why-choose-us.reorder');
    Route::get('why-choose-us/{whyChooseUs}/features', [\App\Http\Controllers\Admin\WhyChooseUsController::class, 'features'])->name('why-choose-us.features');
    Route::post('why-choose-us/{whyChooseUs}/features', [\App\Http\Controllers\Admin\WhyChooseUsController::class, 'storeFeature'])->name('why-choose-us.features.store');
    Route::put('why-choose-us/{whyChooseUs}/features/{feature}', [\App\Http\Controllers\Admin\WhyChooseUsController::class, 'updateFeature'])->name('why-choose-us.features.update');
    Route::delete('why-choose-us/{whyChooseUs}/features/{feature}', [\App\Http\Controllers\Admin\WhyChooseUsController::class, 'destroyFeature'])->name('why-choose-us.features.destroy');
    Route::post('why-choose-us/{whyChooseUs}/features/reorder', [\App\Http\Controllers\Admin\WhyChooseUsController::class, 'reorderFeatures'])->name('why-choose-us.features.reorder');
    
    // Advantages (Keunggulan Kami)
    Route::post('advantages/update-settings', [\App\Http\Controllers\Admin\AdvantageController::class, 'updateSettings'])->name('advantages.update-settings');
    Route::post('advantages/reorder', [\App\Http\Controllers\Admin\AdvantageController::class, 'reorder'])->name('advantages.reorder');
    Route::resource('advantages', \App\Http\Controllers\Admin\AdvantageController::class);
    
    // Academic Calendar
    Route::post('academic-calendar/reorder', [\App\Http\Controllers\Admin\AcademicCalendarController::class, 'reorder'])->name('academic-calendar.reorder');
    Route::resource('academic-calendar', \App\Http\Controllers\Admin\AcademicCalendarController::class)->parameters([
        'academic-calendar' => 'academicCalendar'
    ]);
    
    // Partners/Mitra
    Route::post('partners/update-settings', [\App\Http\Controllers\Admin\PartnerController::class, 'updateSettings'])->name('partners.update-settings');
    Route::post('partners/reorder', [\App\Http\Controllers\Admin\PartnerController::class, 'reorder'])->name('partners.reorder');
    Route::resource('partners', \App\Http\Controllers\Admin\PartnerController::class);
    
    // Testimonials
    Route::post('testimonials/update-settings', [\App\Http\Controllers\Admin\TestimonialController::class, 'updateSettings'])->name('testimonials.update-settings');
    Route::post('testimonials/reorder', [\App\Http\Controllers\Admin\TestimonialController::class, 'reorder'])->name('testimonials.reorder');
    Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class);
    
    // Prodi Unggulan
    Route::resource('prodi-unggulan', \App\Http\Controllers\Admin\ProdiUnggulanController::class)->parameters(['prodi-unggulan' => 'prodiUnggulan']);
    
    // Pimpinan
    Route::resource('pimpinan', \App\Http\Controllers\Admin\PimpinanController::class);
    
    // AI Writing Assistant
    Route::post('/ai/generate', [\App\Http\Controllers\Admin\AIController::class, 'generate'])->name('ai.generate');
});

// Dynamic Pages - Harus di paling bawah agar tidak mengganggu route lain
Route::get('/{slug}', [PageController::class, 'show'])->name('page.show');
