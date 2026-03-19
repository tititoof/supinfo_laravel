@extends('articles.layout')

@section('title', 'Reçus')

@section('content')
<div class="page-header">
    <div>
        <h1>Reçus</h1>
        <p>{{ $receips->total() }} reçu{{ $receips->total() > 1 ? 's' : '' }} au total</p>
    </div>
    <a href="{{ route('receips.create') }}" class="btn btn-primary">
        <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/></svg>
        Nouveau reçu
    </a>
</div>

<div class="card">
    @if ($receips->isEmpty())
        <div style="padding: 3rem; text-align: center; color: var(--muted);">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 1rem; display:block; opacity:.4"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <p style="font-weight:500">Aucun reçu pour l'instant</p>
            <a href="{{ route('receips.create') }}" class="btn btn-primary" style="margin-top:1rem">Créer le premier reçu</a>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Utilisateur</th>
                    <th>Email</th>
                    <th>Créé le</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($receips as $receip)
                <tr>
                    <td style="color:var(--muted); font-size:.8rem;">{{ $receip->id }}</td>
                    <td style="font-weight:600;">
                        <a href="{{ route('receips.show', $receip) }}" style="color:inherit; text-decoration:none;">
                            {{ $receip->user->name }}
                        </a>
                    </td>
                    <td style="color:var(--muted);">{{ $receip->user->email }}</td>
                    <td style="color:var(--muted); font-size:.85rem;">{{ $receip->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <div class="td-actions">
                            <a href="{{ route('receips.show', $receip) }}" class="btn btn-outline btn-sm">Voir</a>
                            <a href="{{ route('receips.edit', $receip) }}" class="btn btn-outline btn-sm">Modifier</a>
                            <form action="{{ route('receips.destroy', $receip) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Supprimer ce reçu ?')">
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

        @if ($receips->hasPages())
            <div style="padding: 1rem 1.1rem; border-top: 1px solid var(--border);">
                {{ $receips->links('articles.pagination') }}
            </div>
        @endif
    @endif
</div>
@endsection