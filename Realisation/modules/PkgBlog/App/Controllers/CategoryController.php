<?php

namespace Modules\PkgBlog\App\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\App\Controllers\BaseController;
use Modules\PkgBlog\App\Models\Category;
use Modules\PkgBlog\App\Requests\CategoryRequest;
use Modules\PkgBlog\App\Services\CategoryService;

class CategoryController extends BaseController
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Category::class);

        $search = request()->search;

        $categories = $this->categoryService->paginate($search);

        return response()->json($categories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $this->authorize('create', Category::class);

        $data = $request->validated();

        $category = $this->categoryService->createCategory($data);

        return response()->json($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $this->authorize('update', $category);

        $category = $this->categoryService->getCategoryById($category->id);

        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $this->authorize('update', $category);

        $data = $request->validated();

        $updateCategory = $this->categoryService->updateCategory($category, $data);

        return response()->json($updateCategory);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $category = $this->categoryService->getCategoryById($id);
            
            $this->authorize('delete', $category);

            if (!$category) {
                return response()->json(['message' => 'Category not found'], Response::HTTP_NOT_FOUND);
            }

            $this->categoryService->deleteCategory($category);

            return response()->json(['message' => "Category deleted successfully"], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (QueryException $e) {
            return response()->json(['message' => "Database error: " . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
