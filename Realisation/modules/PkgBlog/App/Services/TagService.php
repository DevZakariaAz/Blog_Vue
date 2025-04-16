<?php

namespace Modules\PkgBlog\App\Services;

use Illuminate\Support\Facades\Auth;
use Modules\PkgBlog\App\Models\Tag;

class TagService
{
    public function paginate($search, $perPage = 10)
    {
        $query = Tag::latest();

        // Apply search filter
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search['search'] . '%');
            });
        }

        return $query->paginate($perPage);
    }

    public function getTagById($id)
    {
        return Tag::findOrFail($id);
    }

    public function createTag(array $data)
    {
        return Tag::create([
            'name' => $data['name'],
        ]);
    }

    public function updateTag(Tag $tag, array $data)
    {
        $tag->name = $data['name'];

        $tag->save();

        return $tag;
    }

    public function deleteTag(Tag $tag)
    {
        $tag->delete();

        return true;
    }

    public function getTags()
    {
        return Tag::all();
    }
}
