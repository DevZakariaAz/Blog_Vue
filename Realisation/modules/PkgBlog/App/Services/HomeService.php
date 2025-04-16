<?php

namespace Modules\PkgBlog\App\Services;

use Modules\PkgBlog\App\Models\Article;
use Modules\PkgBlog\App\Models\Category;
use Modules\PkgBlog\App\Models\Tag;

class HomeService
{
    public function getHomePageData(): array
    {
        $recentArticles = Article::with('user', 'category')
            ->latest()
            ->take(6)
            ->get()
            ->map(function ($article) {
                // Add profile image to the user for each article
                $article->user->profile_image = $article->user->profile_image;
                return $article;
            });

        // Get the featured article (no need for map here)
        $featuredArticle = Article::with('user', 'category')
            ->orderByDesc('view_count')
            ->limit(1)
            ->first();

        // Add profile image to the user for the featured article
        if ($featuredArticle) {
            $featuredArticle->user->profile_image = $featuredArticle->user->profile_image;
        }

        return [
            'articlesCount' => Article::count(),
            'categoriesCount' => Category::count(),
            'categories' => Category::all(),
            'popularTags' => Tag::withCount('articles')->orderByDesc('articles_count')->limit(5)->get(),
            'popularCategories' => Category::withCount('articles')->orderByDesc('articles_count')->limit(5)->get(),
            'recentArticles' => $recentArticles,
            'readersCount' => Article::sum('view_count'),
            'featuredArticle' => $featuredArticle,
        ];
    }
}
