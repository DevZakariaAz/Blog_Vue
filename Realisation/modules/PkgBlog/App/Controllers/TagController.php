<?php

namespace Modules\PkgBlog\App\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\App\Controllers\BaseController;
use Modules\PkgBlog\App\Models\Tag;
use Modules\PkgBlog\App\Requests\TagRequest;
use Modules\PkgBlog\App\Services\TagService;

class TagController extends BaseController
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Tag::class);
        $search = request()->has('search') ? ['search' => request()->search] : [];
        $tags = $this->tagService->paginate($search);
        return response()->json($tags);
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
    public function store(TagRequest $request)
    {
        $this->authorize('create', Tag::class);
        $data = $request->validated();
        $tag = $this->tagService->createTag($data);
        return response()->json($tag, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        $this->authorize('update', $tag);
        $tag = $this->tagService->getTagById($tag->id);
        return response()->json($tag);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TagRequest $request, Tag $tag)
    {
        $this->authorize('update', $tag);
        $data = $request->validated();
        $updatedTag = $this->tagService->updateTag($tag, $data);
        return response()->json($updatedTag);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tag = $this->tagService->getTagById($id);
        $this->authorize('delete', $tag);
        $this->tagService->deleteTag($tag);
        return response()->json(['message' => 'Tag deleted successfully'], Response::HTTP_OK);
    }
}
