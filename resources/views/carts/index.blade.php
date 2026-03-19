@extends('articles.layout')

@section('title', 'Panier')

@section('content')
<div class="page-header">
    <div>
        <h1>Panier</h1>
        <p>{{ $items->total() }} ligne{{ $items->total() > 1 ? 's' : '' }} dans le panier</p>
    </div>
    <a href="{{ route('cart.create') }}" class="btn btn-primary">
        <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/></svg>
        Ajouter un article
    </a>
</div>

@if ($items->isNotEmpty())
    <div class="card" style="padding: 1.25rem 1.5rem; margin-bottom: 1.25rem; display:flex; align-items:center; justify-content:space-between; background: var(--accent-light); border-color: #dfc8b5;">
        <span style="font-size:.85rem; font-weight:600; color:var(--muted); text-transform:uppercase; letter-spacing:.05em;">Total TTC du panier</span>
        <span style="font-family:'DM Serif Display',serif; font-size:1.8rem; color:var(--accent);">{{ number_format($total, 2, ',', ' ') }} €</span>
    </div>
@endif

<div class="card">
    @if ($items->isEmpty())
        <div style="padding: 3rem; text-align: center; color: var(--muted);">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 1rem; display:block; opacity:.4"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            <p style="font-weight:500">Le panier est vide</p>
            <a href="{{ route('cart.create') }}" class="btn btn-primary" style="margin-top:1rem">Ajouter un article</a>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Article</th>
                    <th>Pays d'origine</th>
                    <th>Prix unitaire TTC</th>
                    <th>Quantité</th>
                    <th>Total TTC</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                <tr>
                    <td style="color:var(--muted); font-size:.8rem;">{{ $item->id }}</td>
                    <td style="font-weight:600;">
                        <a href="{{ route('cart.show', $item) }}" style="color:inherit; text-decoration:none;">
                            {{ $item->article->name }}
                        </a>
                    </td>
                    <td style="color:var(--muted);">{{ $item->article->origin_country }}</td>
                    <td>{{ number_format($item->article->price_ttc, 2, ',', ' ') }} €</td>
                    <td>
                        <span class="badge badge-green">× {{ $item->number }}</span>
                    </td>
                    <td style="font-weight:700; color:var(--accent);">
                        {{ number_format($item->total_price, 2, ',', ' ') }} €
                    </td>
                    <td>
                        <div class="td-actions">
                            <a href="{{ route('cart.edit', $item) }}" class="btn btn-outline btn-sm">Modifier</a>
                            <form action="{{ route('cart.destroy', $item) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Retirer cet article du panier ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Retirer</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if ($items->hasPages())
            <div style="padding: 1rem 1.1rem; border-top: 1px solid var(--border);">
                {{ $items->links('articles.pagination') }}
            </div>
        @endif
    @endif
</div>
@endsection