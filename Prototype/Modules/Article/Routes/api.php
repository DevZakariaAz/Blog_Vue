<?php
use Illuminate\Support\Facades\Route;
use Modules\Article\Http\Controllers\ArticleController;

Route::prefix('api')->group(function () {
    Route::get('articles', [ArticleController::class, 'index']);
    Route::post('articles', [ArticleController::class, 'store']);
    Route::get('articles/{id}', [ArticleController::class, 'show']);
    Route::put('articles/{id}', [ArticleController::class, 'update']);
    Route::delete('articles/{id}', [ArticleController::class, 'destroy']);

    Route::post('articles/import', [ArticleController::class, 'import']);
    Route::get('articles/export', [ArticleController::class, 'export']);
});
