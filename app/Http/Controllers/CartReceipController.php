<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartReceipRequest;
use App\Http\Requests\UpdateCartReceipRequest;
use App\Models\Cart;
use App\Models\CartReceip;
use App\Models\Receip;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartReceipController extends Controller
{
    /**
     * GET /cart-receip
     */
    public function index(): View
    {
        $entries = CartReceip::with(['cart.article', 'receip.user'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('cart-receip.index', compact('entries'));
    }

    /**
     * GET /cart-receip/create
     */
    public function create(): View
    {
        $carts   = Cart::with('article')->orderByDesc('id')->get();
        $receips = Receip::with('user')->orderByDesc('id')->get();

        return view('cart-receip.create', compact('carts', 'receips'));
    }

    /**
     * POST /cart-receip
     */
    public function store(StoreCartReceipRequest $request): RedirectResponse
    {
        CartReceip::create($request->validated());

        return redirect()
            ->route('cart-receip.index')
            ->with('success', 'Association créée avec succès.');
    }

    /**
     * GET /cart-receip/{cart_receip}
     */
    public function show(CartReceip $cartReceip): View
    {
        $cartReceip->load(['cart.article', 'receip.user']);

        return view('cart-receip.show', compact('cartReceip'));
    }

    /**
     * GET /cart-receip/{cart_receip}/edit
     */
    public function edit(CartReceip $cartReceip): View
    {
        $cartReceip->load(['cart.article', 'receip.user']);
        $carts   = Cart::with('article')->orderByDesc('id')->get();
        $receips = Receip::with('user')->orderByDesc('id')->get();

        return view('cart-receip.edit', compact('cartReceip', 'carts', 'receips'));
    }

    /**
     * PUT /cart-receip/{cart_receip}
     */
    public function update(UpdateCartReceipRequest $request, CartReceip $cartReceip): RedirectResponse
    {
        $cartReceip->update($request->validated());

        return redirect()
            ->route('cart-receip.show', $cartReceip)
            ->with('success', 'Association mise à jour avec succès.');
    }

    /**
     * DELETE /cart-receip/{cart_receip}
     */
    public function destroy(CartReceip $cartReceip): RedirectResponse
    {
        $cartReceip->delete();

        return redirect()
            ->route('cart-receip.index')
            ->with('success', 'Association supprimée avec succès.');
    }
}