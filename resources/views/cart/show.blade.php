@extends('articles.layout')

@section('title', 'Ligne panier #' . $cart->id)

@section('content')
<div class="page-header">
    <div>
        <a href="{{ route('cart.index') }}" style="font-size:.85rem; color:var(--muted); text-decoration:none; display:inline-flex; align-items:center; gap:.3rem; margin-bottom:.6rem;">
            <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
            Retour au panier
        </a>
        <h1>Ligne #{{ $cart->id }}</h1>
        <p>{{ $cart->article->name }}</p>
    </div>
    <div style="display:flex; gap:.75rem;">
        <a href="{{ route('cart.edit', $cart) }}" class="btn btn-primary">Modifier</a>
        <form action="{{ route('cart.destroy', $cart) }}" method="POST"
              onsubmit="return confirm('Retirer cet article du panier ?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Retirer</button>
        </form>
    </div>
</div>

<div class="card" style="padding: 1.75rem;">
    <div class="detail-grid">
        <div class="detail-item">
            <div class="detail-label">Article</div>
            <div class="detail-value">
                <a href="{{ route('articles.show', $cart->article) }}" style="color:var(--accent); text-decoration:none; font-weight:600;">
                    {{ $cart->article->name }}
                </a>
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Pays d'origine</div>
            <div class="detail-value">{{ $cart->article->origin_country }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Quantité</div>
            <div class="detail-value">{{ $cart->number }} unité{{ $cart->number > 1 ? 's' : '' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Prix unitaire HT</div>
            <div class="detail-value">{{ number_format($cart->article->unit_price, 2, ',', ' ') }} €</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Remise</div>
            <div class="detail-value">{{ $cart->article->discount }} %</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">TVA</div>
            <div class="detail-value">{{ $cart->article->tva }} %</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Prix unitaire TTC</div>
            <div class="detail-value">{{ number_format($cart->article->price_ttc, 2, ',', ' ') }} €</div>
        </div>
        <div class="detail-item" style="background: var(--accent-light); border-color: #dfc8b5;">
            <div class="detail-label" style="color:var(--accent);">Total TTC</div>
            <div class="detail-value big">{{ number_format($cart->total_price, 2, ',', ' ') }} €</div>
        </div>
    </div>

    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid var(--border); font-size:.8rem; color: var(--muted); display:flex; gap:2rem;">
        <span>Ajouté le {{ $cart->created_at->format('d/m/Y à H:i') }}</span>
        <span>Modifié le {{ $cart->updated_at->format('d/m/Y à H:i') }}</span>
    </div>
</div>
@endsection