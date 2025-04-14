<?php

namespace Modules\Article\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Article\Models\Article;
use Modules\Article\Services\ArticleService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArticleController extends Controller
{

    protected $articleService;

    public function __construct(ArticleService  $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index( Request $request)
    {
        $search = $request->query('search', null);

        $articles = $this->articleService->getAllOrSearch($search);

         return response()->json($articles);
    }

    public function import(Request $request)
    {
        $articles = $request->input('articles', []);

        foreach ($articles as $article) {
            Article::updateOrCreate(['id' => $article['id']], ['title' => $article['title']]);
        }

        return response()->json(['message' => 'Import successful'], 200);
    }
    public function export()
    {
        $articles = Article::all(['id', 'title']);
        $csv = "ID,Title\n" . $articles->map(fn($a) => "{$a->id},{$a->title}")->implode("\n");

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="articles.csv"',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $article = $this->articleService->create($data);

        return response()->json($article, 201);
    }
    public function show($id)
    {
        $article = $this->articleService->getById($id);

        if ($article) {
            return response()->json($article);
        }

        return response()->json(['message' => 'Article not found'], 404);
    }
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $updated = $this->articleService->update($id, $data);

        if ($updated) {
            return response()->json(['message' => 'Article updated successfully']);
        }

        return response()->json(['message' => 'Article not found'], 404);
    }

    public function destroy($id)
    {
        $deleted = $this->articleService->delete($id);

        if ($deleted) {
            return response()->json(['message' => 'Article deleted successfully']);
        }

        return response()->json(['message' => 'Article not found'], 404);
    }
  
}
