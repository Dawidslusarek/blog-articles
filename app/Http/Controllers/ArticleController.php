<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Exception;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Requests\Article\StoreArticleRequest;
use App\Http\Requests\Article\DeleteArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;

class ArticleController extends Controller
{

    public function view(): ?Response
    {
        return Inertia::render('Articles/ArticlesList', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register')
        ]);
    }

    public function singleArticle(string $slug): ?Response
    {
        $article = Article::where('slug', $slug)->first();

        return Inertia::render('Articles/Single', [
            'article' => $article,
            'user' => Auth::getUser()
        ]);
    }
    public function index(Request $request): ?JsonResponse
    {
        $limit = $request->query('limit') ?? 5;
        $offset = $request->query('offset') ?? 0;

        return response()->json(
            DB::table('articles')
                ->limit($limit)
                ->offset($offset)
                ->get()
        );
    }

    public function store(StoreArticleRequest $request): ?JsonResponse
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['title'], '-');

        try {
            $article = Article::create($data);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

        return response()->json($article, 201);
    }

    public function update(UpdateArticleRequest $request): ?JsonResponse
    {
        $data = $request->validated();
        $oldSlug = $request->get('slug');
        $data['slug'] = Str::slug($data['title'], '-');

        try {
            $article = Article::where('slug', $oldSlug)
                ->update([
                    'title' => $data['title'],
                    'slug' => $data['slug'],
                    'content' => $data['content']
                ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

        return response()->json($article, 200);
    }

    public function destory(DeleteArticleRequest $request, string $slug): ?JsonResponse
    {
        try {
            $article = Article::where('slug', $slug)
                ->delete();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

        return response()->json($article, 200);
    }
}
