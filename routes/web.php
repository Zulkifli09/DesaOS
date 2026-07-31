<?php

declare(strict_types=1);

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home');
Route::get('/profil', [\App\Http\Controllers\Frontend\ProfileController::class, 'index'])->name('profil');
Route::get('/berita', [\App\Http\Controllers\Frontend\ArticleController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [\App\Http\Controllers\Frontend\ArticleController::class, 'show'])->name('berita.show');
Route::get('/pengumuman', [\App\Http\Controllers\Frontend\AnnouncementController::class, 'index'])->name('pengumuman.index');
Route::get('/pengumuman/{slug}', [\App\Http\Controllers\Frontend\AnnouncementController::class, 'show'])->name('pengumuman.show');
Route::get('/galeri', [\App\Http\Controllers\Frontend\GalleryController::class, 'index'])->name('galeri.index');
Route::get('/galeri/album/{slug}', [\App\Http\Controllers\Frontend\GalleryController::class, 'album'])->name('galeri.album');
Route::get('/potensi', [\App\Http\Controllers\Frontend\VillagePotentialController::class, 'index'])->name('potensi.index');
Route::get('/potensi/{slug}', [\App\Http\Controllers\Frontend\VillagePotentialController::class, 'show'])->name('potensi.show');
Route::get('/umkm', [\App\Http\Controllers\Frontend\UmkmController::class, 'index'])->name('umkm.index');
Route::get('/umkm/{slug}', [\App\Http\Controllers\Frontend\UmkmController::class, 'show'])->name('umkm.show');
Route::get('/statistik', [\App\Http\Controllers\Frontend\StatisticController::class, 'index'])->name('statistik.index');

Route::get('/faq', [\App\Http\Controllers\Frontend\FaqController::class, 'index'])->name('faq.index');
Route::get('/dokumen', [\App\Http\Controllers\Frontend\DocumentController::class, 'index'])->name('dokumen.index');
Route::get('/dokumen/{document}/download', [\App\Http\Controllers\Frontend\DocumentController::class, 'download'])->name('dokumen.download');
Route::get('/kontak', [\App\Http\Controllers\Frontend\ContactController::class, 'index'])->name('kontak.index');
Route::post('/kontak', [\App\Http\Controllers\Frontend\ContactController::class, 'store'])->name('kontak.store');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('articles', \App\Http\Controllers\Admin\ArticleController::class)->except('show');
        Route::resource('announcements', \App\Http\Controllers\Admin\AnnouncementController::class)->except('show');
        Route::resource('gallery_albums', \App\Http\Controllers\Admin\GalleryAlbumController::class)->except('show');
        Route::resource('galleries', \App\Http\Controllers\Admin\GalleryController::class)->except('show');
        Route::resource('potentials', \App\Http\Controllers\Admin\VillagePotentialController::class)->except('show');
        Route::resource('umkm', \App\Http\Controllers\Admin\UmkmController::class)->except('show');
        Route::get('statistics', [\App\Http\Controllers\Admin\StatisticController::class, 'index'])->name('statistics.index');
        Route::put('statistics', [\App\Http\Controllers\Admin\StatisticController::class, 'update'])->name('statistics.update');
        
        Route::resource('faqs', \App\Http\Controllers\Admin\FaqController::class)->except('show');
        Route::resource('documents', \App\Http\Controllers\Admin\DocumentController::class)->except('show');
        Route::resource('contact_messages', \App\Http\Controllers\Admin\ContactMessageController::class)->only(['index', 'show', 'destroy']);
        
        Route::post('/media/upload', [\App\Http\Controllers\Admin\MediaController::class, 'upload'])->name('media.upload');

        // Media Routes
        Route::get('media', [\App\Http\Controllers\Admin\MediaController::class, 'index'])->name('media.index');
        Route::post('media', [\App\Http\Controllers\Admin\MediaController::class, 'store'])->name('media.store');
        Route::delete('media/{media}', [\App\Http\Controllers\Admin\MediaController::class, 'destroy'])->name('media.destroy');
    });
});

require __DIR__.'/auth.php';
