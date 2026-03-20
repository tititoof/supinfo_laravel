<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReceipRequest;
use App\Http\Requests\UpdateReceipRequest;
use App\Models\Receip;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReceipController extends Controller
{
    /**
     * GET /receips
     */
    public function index(): View
    {
        $receips = Receip::with('user')->orderByDesc('created_at')->paginate(10);

        return view('receips.index', compact('receips'));
    }

    /**
     * GET /receips/create
     */
    public function create(): View
    {
        $users = User::orderBy('name')->get();

        return view('receips.create', compact('users'));
    }

    /**
     * POST /receips
     */
    public function store(StoreReceipRequest $request): RedirectResponse
    {
        Receip::create($request->validated());

        return redirect()
            ->route('receips.index')
            ->with('success', 'Reçu créé avec succès.');
    }

    /**
     * GET /receips/{receip}
     */
    public function show(Receip $receip): View
    {
        $receip->load('user');

        return view('receips.show', compact('receip'));
    }

    /**
     * GET /receips/{receip}/edit
     */
    public function edit(Receip $receip): View
    {
        $receip->load('user');
        $users = User::orderBy('name')->get();

        return view('receips.edit', compact('receip', 'users'));
    }

    /**
     * PUT /receips/{receip}
     */
    public function update(UpdateReceipRequest $request, Receip $receip): RedirectResponse
    {
        $receip->update($request->validated());

        return redirect()
            ->route('receips.show', $receip)
            ->with('success', 'Reçu mis à jour avec succès.');
    }

    /**
     * DELETE /receips/{receip}
     */
    public function destroy(Receip $receip): RedirectResponse
    {
        $receip->delete();

        return redirect()
            ->route('receips.index')
            ->with('success', 'Reçu supprimé avec succès.');
    }
}