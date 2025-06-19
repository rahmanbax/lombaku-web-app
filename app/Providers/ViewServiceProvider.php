<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Tag; // <-- Import model Tag

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Menggunakan View Composer untuk komponen header
        // 'components.public-header-nav' adalah path ke file komponen Anda
        View::composer('components.public-header-nav', function ($view) {
            // Ambil semua tag dari database, urutkan berdasarkan nama,
            // dan simpan dalam cache selama 1 jam untuk performa.
            $categories = cache()->remember('all_tags', 3600, function () {
                return Tag::orderBy('nama_tag')->get();
            });

            // Kirim data ke view dengan nama variabel 'categories'
            $view->with('categories', $categories);
        });
    }
}