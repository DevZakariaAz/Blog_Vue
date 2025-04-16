<?php

namespace Modules\PkgBlog\App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\PkgBlog\App\Models\Article;
use Modules\PkgBlog\App\Models\ArticleImage;

class ArticleService
{
    public function paginate($filters = [], $perPage = 10)
    {
        $query = Article::latest()->with(['user', 'category', 'tags']);

        // Apply category filter
        if (!empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        // Apply tag filter
        if (!empty($filters['tag'])) {
            $query->whereHas('tags', function ($query) use ($filters) {
                $query->where('tags.id', $filters['tag']);
            });
        }

        // Apply search filter
        if (!empty($filters['search'])) {
            $query->where(function ($query) use ($filters) {
                $query->where('title', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('content', 'like', '%' . $filters['search'] . '%');
            });
        }

        $paginated = $query->paginate($perPage);

        $paginated->getCollection()->transform(function ($article) {
            $article->user->profile_image = $article->user->profile_image;
            return $article;
        });

        return $paginated;
    }

    public function getArticleById($id)
    {
        $article = Article::with(['user', 'images', 'category', 'tags', 'comments.user'])->findOrFail($id);

        if ($article) {
            $article->user->profile_image = $article->user->profile_image;
        }

        foreach ($article->comments as $comment) {
            if ($comment->user) {
                $comment->user->profile_image = $comment->user->profile_image;
            }
        }

        $article->increment('view_count');

        return $article;
    }

    public function createArticle(array $data, $images = [])
    {
        // Store featured image
        $featuredImagePath = null;
        if (isset($data['featured_image'])) {
            $featuredImagePath = $data['featured_image']->store('articles/featured', 'public');
        }

        $article = Article::create([
            'title' => $data['title'],
            'category_id' => $data['category_id'],
            'content' => $data['content'],
            'description' => $data['description'],
            'slug' => $data['slug'],
            'featured_image' => $featuredImagePath, // Store the path
            'status' => $data['status'],
            'view_count' => 0,
            'user_id' => Auth::id(),
        ]);

        // Handle additional images if needed
        foreach ($images as $image) {
            $path = $image->store('articles/gallery', 'public');
            ArticleImage::create(['article_id' => $article->id, 'image_path' => $path]);
        }

        if (!empty($data['tags'])) {
            $article->tags()->attach($data['tags']);
        }

        return $article;
    }

    public function updateArticle(Article $article, array $data, array $images = [])
    {
        // Handle featured image
        if (isset($data['remove_image']) && $data['remove_image'] === '1') {
            // Delete the existing image
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $featuredImagePath = null;
        }
        // Handle new featured image upload
        elseif (isset($data['featured_image']) && $data['featured_image'] instanceof \Illuminate\Http\UploadedFile) {
            // Delete old image if exists
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }

            // Store new image
            $featuredImagePath = $data['featured_image']->store('articles/featured', 'public');
        }
        // If no new image and not removing, keep the existing one
        else {
            $featuredImagePath = $article->featured_image;
        }

        $article->update([
            'title' => $data['title'],
            'category_id' => $data['category_id'],
            'content' => $data['content'],
            'description' => $data['description'],
            'slug' => $data['slug'],
            'featured_image' => $featuredImagePath,
            'status' => $data['status'],
        ]);

        // Handle additional images if needed
        foreach ($images as $image) {
            $path = $image->store('articles/gallery', 'public');
            ArticleImage::create(['article_id' => $article->id, 'image_path' => $path]);
        }

        if (isset($data['tags'])) {
            $article->tags()->sync($data['tags']);
        }

        return $article;
    }

    public function deleteArticle(Article $article)
    {
        // Delete featured image
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        // Delete gallery images
        foreach ($article->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $article->delete();
        return true;
    }

    public function getRelatedArticles(Article $article, int $limit = 3)
    {
        return Article::with('images')
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->latest()
            ->take($limit)
            ->get();
    }

    public function search(string $query)
    {
        return Article::where('title', 'like', '%' . $query . '%')
            ->limit(10)
            ->get(['id', 'title', 'featured_image']);
    }
}
