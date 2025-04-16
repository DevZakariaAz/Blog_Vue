<?php

namespace Modules\PkgBlog\App\Services;

use Illuminate\Support\Facades\Auth;
use Modules\PkgBlog\App\Models\Comment;

class CommentService
{
    public function paginate($search, $perPage = 10)
    {
        $query = Comment::latest()->with(['user', 'article']);

        // Apply search filter
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search['search'] . '%');
            });
        }

        return $query->paginate($perPage);
    }

    public function getCommentById($id)
    {
        return Comment::findOrFail($id);
    }

    public function createComment(array $data)
    {
        return Comment::create([
            'content' => $data['content'],
            'user_id' => Auth::id(),
            'article_id' => $data['article_id'],
            'parent_id' => $data['parent_id'],
        ]);
    }

    public function updateComment(Comment $comment, array $data)
    {
        $comment->update([
            'content' => $data['content'],
            'user_id' => Auth::id(),
            'article_id' => $data['article_id'],
            'parent_id' => $data['parent_id'],
        ]);

        return $comment;
    }

    public function deleteComment(Comment $comment)
    {
        return $comment->delete();
    }

}
