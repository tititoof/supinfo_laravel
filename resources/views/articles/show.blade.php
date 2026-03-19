@extends('articles.layout')

@section('title', $article->name)

@section('content')
<div class="page-header">
    <div>
        <a href="{{ route('articles.index') }}" style="font-size:.85rem; color:var(--muted); text-decoration:none; display:inline-flex; align-items:center; gap:.3rem; margin-bottom:.6rem;">
            <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
            Retour à la liste
        </a>
        <h1>{{ $article->name }}</h1>
        <p>Article #{{ $article->id }}</p>
    </div>
    <div style="display:flex; gap:.75rem;">
        <a href="{{ route('articles.edit', $article) }}" class="btn btn-primary">Modifier</a>
        <form action="{{ route('articles.destroy', $article) }}" method="POST"
              onsubmit="return confirm('Supprimer cet article définitivement ?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Supprimer</button>
        </form>
    </div>
</div>

<div class="card" style="padding: 1.75rem;">
    <div class="detail-grid">
        <div class="detail-item">
            <div class="detail-label">Nom</div>
            <div class="detail-value">{{ $article->name }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Pays d'origine</div>
            <div class="detail-value">{{ $article->origin_country }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Stock disponible</div>
            <div class="detail-value">
                <span class="badge {{ $article->nb_stock > 0 ? 'badge-green' : 'badge-red' }}" style="font-size:.9rem; padding:.3rem .8rem;">
                    {{ $article->nb_stock }} unité{{ $article->nb_stock > 1 ? 's' : '' }}
                </span>
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Prix unitaire HT</div>
            <div class="detail-value">{{ number_format($article->unit_price, 2, ',', ' ') }} €</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Remise</div>
            <div class="detail-value">{{ $article->discount }} %</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">TVA</div>
            <div class="detail-value">{{ $article->tva }} %</div>
        </div>
        <div class="detail-item" style="grid-column: 1 / -1; background: var(--accent-light); border-color: #dfc8b5;">
            <div class="detail-label" style="color:var(--accent);">Prix TTC (après remise)</div>
            <div class="detail-value big">{{ number_format($article->price_ttc, 2, ',', ' ') }} €</div>
        </div>
    </div>

    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid var(--border); font-size:.8rem; color: var(--muted); display:flex; gap:2rem;">
        <span>Créé le {{ $article->created_at->format('d/m/Y à H:i') }}</span>
        <span>Modifié le {{ $article->updated_at->format('d/m/Y à H:i') }}</span>
    </div>
</div>
@endsection