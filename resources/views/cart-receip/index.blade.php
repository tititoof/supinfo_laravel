@extends('articles.layout')

@section('title', 'Associations Panier / Reçu')

@section('content')
<div class="page-header">
    <div>
        <h1>Paniers & Reçus</h1>
        <p>{{ $entries->total() }} association{{ $entries->total() > 1 ? 's' : '' }} au total</p>
    </div>
    <a href="{{ route('cart-receip.create') }}" class="btn btn-primary">
        <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/></svg>
        Nouvelle association
    </a>
</div>

<div class="card">
    @if ($entries->isEmpty())
        <div style="padding: 3rem; text-align: center; color: var(--muted);">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 1rem; display:block; opacity:.4"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
            <p style="font-weight:500">Aucune association pour l'instant</p>
            <a href="{{ route('cart-receip.create') }}" class="btn btn-primary" style="margin-top:1rem">Créer une association</a>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Panier</th>
                    <th>Article</th>
                    <th>Qté</th>
                    <th>Reçu</th>
                    <th>Utilisateur</th>
                    <th>Créé le</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($entries as $entry)
                <tr>
                    <td style="color:var(--muted); font-size:.8rem;">{{ $entry->id }}</td>
                    <td>
                        <a href="{{ route('cart.show', $entry->cart) }}" style="color:var(--accent); text-decoration:none; font-weight:600;">
                            Panier #{{ $entry->cart_id }}
                        </a>
                    </td>
                    <td>{{ $entry->cart->article->name }}</td>
                    <td>
                        <span class="badge badge-green">× {{ $entry->cart->number }}</span>
                    </td>
                    <td>
                        <a href="{{ route('receips.show', $entry->receip) }}" style="color:var(--accent); text-decoration:none; font-weight:600;">
                            Reçu #{{ $entry->receip_id }}
                        </a>
                    </td>
                    <td style="color:var(--muted);">{{ $entry->receip->user->name }}</td>
                    <td style="color:var(--muted); font-size:.85rem;">{{ $entry->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <div class="td-actions">
                            <a href="{{ route('cart-receip.show', $entry) }}" class="btn btn-outline btn-sm">Voir</a>
                            <a href="{{ route('cart-receip.edit', $entry) }}" class="btn btn-outline btn-sm">Modifier</a>
                            <form action="{{ route('cart-receip.destroy', $entry) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Supprimer cette association ?')">
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

        @if ($entries->hasPages())
            <div style="padding: 1rem 1.1rem; border-top: 1px solid var(--border);">
                {{ $entries->links('articles.pagination') }}
            </div>
        @endif
    @endif
</div>
@endsection