<?php

namespace Modules\PkgBlog\App\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Modules\PkgBlog\App\Models\Category;

class CategoryService
{
    public function paginate($search, $perPage = 10)
    {
        $query = Category::latest();

        // Apply search filter
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search['search'] . '%');
            });
        }

        return $query->paginate($perPage);
    }

    public function getCategoryById($id)
    {
        return Category::findOrFail($id);
    }

    public function createCategory(array $data)
    {
        return Category::create([
            'name' => $data['name'],
        ]);
    }

    public function updateCategory(Category $category, array $data)
    {
        $category->name = $data['name'];

        $category->save();

        return $category;
    }

    public function deleteCategory(Category $category)
    {
        $defaultCategory = Category::where('name', 'Uncategorized')->first();

        if (!$defaultCategory) {
            throw new ModelNotFoundException("Default category not found. Cannot delete.");
        }

        // Reassign articles before deletion
        $category->articles()->update(['category_id' => $defaultCategory->id]);

        // Delete the category
        return $category->delete();
    }

    public function getCategories()
    {
        return Category::all();
    }
}
