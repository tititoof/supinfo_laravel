<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * GET /articles
     */
    public function index(): View
    {
        $articles = Article::orderBy('name')->paginate(10);
        
        return view('articles.index', compact('articles'));
        
    }

    /**
     * GET /articles/create
     */
    public function create(): View
    {
        return view('articles.create');
    }

    /**
     * POST /articles
     */
    public function store(StoreArticleRequest $request): RedirectResponse
    {
        Article::create($request->validated());

        return redirect()
            ->route('articles.index')
            ->with('success', 'Article créé avec succès.');
    }

    /**
     * GET /articles/{article}
     */
    public function show(Article $article): View
    {
        return view('articles.show', compact('article'));
    }

    /**
     * GET /articles/{article}/edit
     */
    public function edit(Article $article): View
    {
        return view('articles.edit', compact('article'));
    }

    /**
     * PUT /articles/{article}
     */
    public function update(UpdateArticleRequest $request, Article $article): RedirectResponse
    {
        $article->update($request->validated());

        return redirect()
            ->route('articles.show', $article)
            ->with('success', 'Article mis à jour avec succès.');
    }

    /**
     * DELETE /articles/{article}
     */
    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return redirect()
            ->route('articles.index')
            ->with('success', 'Article supprimé avec succès.');
    }
}