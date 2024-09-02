<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Exception;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Comment\StoreCommentRequest;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request): ?JsonResponse
    {
        $data = $request->validated();

        $article = Article::where('slug', $data['article_slug'])->first();

        $data['article_id'] = $article->id;

        try {
            $comment = Comment::create($data);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

        return response()->json($comment, 201);
    }

    public function getArticleComments(string $slug): ?JsonResponse
    {
        $article = Article::where('slug', $slug)->first();

        try {
            $comments = DB::table('comments')
                ->where('article_id', $article->id)
                ->join('users', 'users.id', '=', 'comments.user_id')
                ->get();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

        return response()->json($comments, 201);
    }
}
