<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Models\Article;
use App\Models\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * GET /cart
     */
    public function index(): View
    {
        $items = Cart::with('article')->orderByDesc('created_at')->paginate(10);

        $total = Cart::with('article')->get()->sum(fn ($item) => $item->total_price);

        return view('cart.index', compact('items', 'total'));
    }

    /**
     * GET /cart/create
     */
    public function create(): View
    {
        $articles = Article::orderBy('name')->get();

        return view('cart.create', compact('articles'));
    }

    /**
     * POST /cart
     */
    public function store(StoreCartRequest $request): RedirectResponse
    {
        Cart::create($request->validated());

        return redirect()
            ->route('cart.index')
            ->with('success', 'Article ajouté au panier.');
    }

    /**
     * GET /cart/{cart}
     */
    public function show(Cart $cart): View
    {
        $cart->load('article');

        return view('cart.show', compact('cart'));
    }

    /**
     * GET /cart/{cart}/edit
     */
    public function edit(Cart $cart): View
    {
        $cart->load('article');
        $articles = Article::orderBy('name')->get();

        return view('cart.edit', compact('cart', 'articles'));
    }

    /**
     * PUT /cart/{cart}
     */
    public function update(UpdateCartRequest $request, Cart $cart): RedirectResponse
    {
        $cart->update($request->validated());

        return redirect()
            ->route('cart.show', $cart)
            ->with('success', 'Ligne de panier mise à jour.');
    }

    /**
     * DELETE /cart/{cart}
     */
    public function destroy(Cart $cart): RedirectResponse
    {
        $cart->delete();

        return redirect()
            ->route('cart.index')
            ->with('success', 'Article retiré du panier.');
    }
}