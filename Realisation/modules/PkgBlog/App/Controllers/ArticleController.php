<?php

namespace Modules\PkgBlog\App\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\PkgBlog\App\Models\Article;
use Modules\PkgBlog\App\Models\Category;
use Modules\PkgBlog\App\Models\Tag;
use Modules\PkgBlog\App\Services\ArticleService;
use Illuminate\Http\Response;
use Modules\Core\App\Controllers\BaseController;
use Modules\PkgBlog\App\Requests\ArticleRequest;

class ArticleController extends BaseController
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
        // $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $filters = [
            'category' => $request->category,
            'tag' => $request->tag,
            'search' => $request->search,
        ];

        $articles = $this->articleService->paginate($filters);
        $categories = Category::all();
        $tags = Tag::all();

        return response()->json([
            'articles' => $articles,
            'categories' => $categories,
            'tags' => $tags
        ]);
    }

    public function show(string $id)
    {
        $article = $this->articleService->getArticleById($id);
        $relatedArticles = $this->articleService->getRelatedArticles($article);
        $categories = Category::all();
        $commentableId = $article->id;
        $commentableType = Article::class;

        return response()->json([
            'article' => $article,
            'relatedArticles' => $relatedArticles,
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        $this->authorize('create', Article::class);

        $categories = Category::all();
        $allTags = Tag::all();

        return response()->json([
            'categories' => $categories,
            'tags' => $allTags
        ]);
    }

    public function store(ArticleRequest $request)
    {
        $this->authorize('create', Article::class);

        $validated = $request->validated();

        // Get the featured image from request
        $validated['featured_image'] = $request->file('featured_image');

        $article = $this->articleService->createArticle(
            $validated,
            $request->file('images') ?? []
        );

        return response()->json([
            'message' => "The article has been created",
            'article' => $article,
            'featured_image_url' => $article->featured_image_url
        ], Response::HTTP_CREATED);
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $this->authorize('update', $article);
        $categories = Category::all();
        $allTags = Tag::all();
        $selectedTags = $article->tags->pluck('id')->toArray();

        return response()->json([
            'article' => $article,
            'categories' => $categories,
            'tags' => $allTags,
            'selectedTags' => $selectedTags
        ]);
    }

    public function update(ArticleRequest $request, $id)
    {
        $article = Article::findOrFail($id);
        $this->authorize('update', $article);
    
        $validated = $request->validated();
    
        // Handle optional featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image');
        }
    
        // Handle gallery images if provided
        $images = $request->file('images') ?? [];
    
        $this->articleService->updateArticle($article, $validated, $images);
    
        return response()->json([
            'message' => "The article has been updated",
            'article' => $article->fresh(),
            'featured_image_url' => $article->featured_image_url
        ]);
    }    

    public function destroy(string $id)
    {
        $article = Article::findOrFail($id);
        $this->authorize('delete', $article);
        $this->articleService->deleteArticle($article);

        return response()->json([
            'message' => "The article has been deleted"
        ], Response::HTTP_NO_CONTENT);
    }

    public function search(Request $request)
    {
        $query = $request->query('query');

        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        $articles = $this->articleService->search($query);
        return response()->json($articles);
    }
}
