@extends('auth.layout')

@section('title', 'Liste des articles')

@section('content')
<div class="page-header">
    <div>
        <h1>Articles</h1>
        <p>{{ $articles->total() }} article{{ $articles->total() > 1 ? 's' : '' }} au total</p>
    </div>
    <a href="{{ route('articles.create') }}" class="btn btn-primary">
        <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/></svg>
        Nouvel article
    </a>
</div>

<div class="card">
    @if ($articles->isEmpty())
        <div style="padding: 3rem; text-align: center; color: var(--muted);">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 1rem; display:block; opacity:.4"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
            <p style="font-weight:500">Aucun article pour l'instant</p>
            <a href="{{ route('articles.create') }}" class="btn btn-primary" style="margin-top:1rem">Créer le premier article</a>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Pays d'origine</th>
                    <th>Stock</th>
                    <th>Prix HT</th>
                    <th>Remise</th>
                    <th>TVA</th>
                    <th>Prix TTC</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articles as $article)
                <tr>
                    <td style="color:var(--muted); font-size:.8rem;">{{ $article->id }}</td>
                    <td style="font-weight:600;">
                        <a href="{{ route('articles.show', $article) }}" style="color:inherit; text-decoration:none;">
                            {{ $article->name }}
                        </a>
                    </td>
                    <td>{{ $article->origin_country }}</td>
                    <td>
                        <span class="badge {{ $article->nb_stock > 0 ? 'badge-green' : 'badge-red' }}">
                            {{ $article->nb_stock }}
                        </span>
                    </td>
                    <td>{{ number_format($article->unit_price, 2, ',', ' ') }} €</td>
                    <td>{{ $article->discount }} %</td>
                    <td>{{ $article->tva }} %</td>
                    <td style="font-weight:600; color:var(--accent);">{{ number_format($article->price_ttc, 2, ',', ' ') }} €</td>
                    <td>
                        <div class="td-actions">
                            <a href="{{ route('articles.edit', $article) }}" class="btn btn-outline btn-sm">Modifier</a>
                            <form action="{{ route('articles.destroy', $article) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Supprimer cet article ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if ($articles->hasPages())
            <div style="padding: 1rem 1.1rem; border-top: 1px solid var(--border);">
                {{ $articles->links('articles.pagination') }}
            </div>
        @endif
    @endif
</div>
@endsection