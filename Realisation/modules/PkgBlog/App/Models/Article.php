<?php

namespace Modules\PkgBlog\App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory;

    protected $fillable = ['title', 'content', 'user_id', 'category_id', 'description', 'slug', 'featured_image', 'view_count', 'status'];

    protected $appends = ['featured_image_url'];

    public function getFeaturedImageUrlAttribute()
    {
        if (!$this->featured_image) {
            return asset('images/default-article.jpg'); // Default image
        }

        return asset('storage/' . $this->featured_image);
    }

    // In your Article model
    public function getProcessedContentAttribute()
    {
        $content = $this->content;

        // Convert any remaining blob URLs to permanent URLs if needed
        $content = preg_replace_callback(
            '/src="(blob:[^"]+)"/',
            function ($matches) {
                // You might want to handle failed uploads here
                return 'src="' . asset('images/image-upload-failed.jpg') . '"';
            },
            $content
        );

        return $content;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function images()
    {
        return $this->hasMany(ArticleImage::class);
    }
}
