<?php

namespace Modules\Article\Services;

use Modules\Article\Models\Article;
use Illuminate\Database\Eloquent\Collection;

class ArticleService
{
    public function create(array $data)
    {
        return Article::create($data);
    }
    public function getAllOrSearch($search = null)
    {
        $query = Article::query();

        // If search term is provided, filter by title
        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        return $query->get();
    }
    public function getById(int $id)
    {
        return Article::find($id);
    }
    public function update(int $id, array $data): bool
    {
        $article = $this->getById($id);
        if ($article) {
            return $article->update($data);
        }

        return false;
    }

    public function delete(int $id): bool
    {
        $article = $this->getById($id);
        if ($article) {
            return $article->delete();
        }

        return false;
    }

}
