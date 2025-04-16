<?php

namespace Modules\PkgBlog\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /** @use HasFactory<\Database\Factories\TagFactory> */
    use HasFactory;

    protected $fillable = ['name'];

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
