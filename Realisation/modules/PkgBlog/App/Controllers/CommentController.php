<?php

namespace Modules\PkgBlog\App\Controllers;

use Illuminate\Http\Response;
use Modules\Core\App\Controllers\BaseController;
use Modules\PkgBlog\App\Models\Comment;
use Modules\PkgBlog\App\Requests\CommentRequest;
use Modules\PkgBlog\App\Services\CommentService;

class CommentController extends BaseController
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->search;
        $comments = $this->commentService->paginate($search);

        return response()->json($comments);
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
    public function store(CommentRequest $request)
    {
        $data = $request->validated();
        $comment = $this->commentService->createComment($data);

        return response()->json([
            'message' => "The comment has been created",
            'comment' => $comment,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $comment = $this->commentService->getCommentById($id);

        return response()->json($comment);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $comment = Comment::findOrFail($id);

        return response()->json($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, $id)
    {
        $comment = Comment::findOrFail($id);
        $validated = $request->validated();
        $this->commentService->updateComment($comment, $validated);

        return response()->json([
            'message' => "The comment has been updated",
            'comment' => $comment->fresh(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $this->commentService->deleteComment($comment);

        return response()->json([
            'message' => "The comment has been deleted"
        ], Response::HTTP_NO_CONTENT);
    }
}
