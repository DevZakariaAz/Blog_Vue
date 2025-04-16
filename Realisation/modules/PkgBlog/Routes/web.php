<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Modules\PkgBlog\App\Controllers\ArticleController;
use Modules\PkgBlog\App\Controllers\ArticleImageController;
use Modules\PkgBlog\App\Controllers\CategoryController;
use Modules\PkgBlog\App\Controllers\ChartDataController;
use Modules\PkgBlog\App\Controllers\CommentController;
use Modules\PkgBlog\App\Controllers\HomeController;
use Modules\PkgBlog\App\Controllers\TagController;

Route::prefix('api/articles')->group(function () {

    Route::get('/', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/search', [ArticleController::class, 'search'])->name('articles.search');

    Route::middleware(['auth', 'web'])->group(function () {
        Route::get('/create', [ArticleController::class, 'create'])->name('articles.create');
        Route::post('/store', [ArticleController::class, 'store'])->name('articles.store');
        Route::post('/upload-image', [ArticleImageController::class, 'store']);
        Route::get('/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
        Route::put('/{article}', [ArticleController::class, 'update'])->name('articles.update');
        Route::delete('/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
    });

    Route::get('/{article}', [ArticleController::class, 'show'])->name('articles.show');
});

Route::prefix('api/categories')->middleware(['auth', 'web'])->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/{category}', [CategoryController::class, 'update'])->name('categories.update');
});

Route::prefix('api/tags')->middleware(['auth', 'web'])->group(function () {
    Route::get('/', [TagController::class, 'index'])->name('tags.index');
    Route::get('/create', [TagController::class, 'create'])->name('tags.create');
    Route::post('/store', [TagController::class, 'store'])->name('tags.store');
    Route::delete('/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');
    Route::get('/{tag}/edit', [TagController::class, 'edit'])->name('tags.edit');
    Route::put('/{tag}', [TagController::class, 'update'])->name('tags.update');
});

Route::prefix('api/comments')->middleware(['auth', 'web'])->group(function () {
    Route::get('/', [CommentController::class, 'index'])->name('comments.index');
    Route::get('/create', [CommentController::class, 'create'])->name('comments.create');
    Route::post('/store', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::get('/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/{comment}', [CommentController::class, 'update'])->name('comments.update');
});

Route::prefix('/chart-data')->middleware(['auth', 'web'])->group(function () {
    Route::get('/articles', [ChartDataController::class, 'articles']);
});

Route::get('/api/home-data', [HomeController::class, 'index'])->name('home.index');
