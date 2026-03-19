@extends('articles.layout')

@section('title', 'Reçu #' . $receip->id)

@section('content')
<div class="page-header">
    <div>
        <a href="{{ route('receips.index') }}" style="font-size:.85rem; color:var(--muted); text-decoration:none; display:inline-flex; align-items:center; gap:.3rem; margin-bottom:.6rem;">
            <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
            Retour aux reçus
        </a>
        <h1>Reçu #{{ $receip->id }}</h1>
        <p>{{ $receip->user->name }}</p>
    </div>
    <div style="display:flex; gap:.75rem;">
        <a href="{{ route('receips.edit', $receip) }}" class="btn btn-primary">Modifier</a>
        <form action="{{ route('receips.destroy', $receip) }}" method="POST"
              onsubmit="return confirm('Supprimer ce reçu définitivement ?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Supprimer</button>
        </form>
    </div>
</div>

<div class="card" style="padding: 1.75rem;">
    <div class="detail-grid">
        <div class="detail-item">
            <div class="detail-label">Numéro du reçu</div>
            <div class="detail-value">#{{ $receip->id }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Utilisateur</div>
            <div class="detail-value" style="font-weight:600;">{{ $receip->user->name }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Email</div>
            <div class="detail-value">
                <a href="mailto:{{ $receip->user->email }}" style="color:var(--accent); text-decoration:none;">
                    {{ $receip->user->email }}
                </a>
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-label">ID utilisateur</div>
            <div class="detail-value" style="color:var(--muted);">{{ $receip->users_id }}</div>
        </div>
    </div>

    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid var(--border); font-size:.8rem; color: var(--muted); display:flex; gap:2rem;">
        <span>Créé le {{ $receip->created_at->format('d/m/Y à H:i') }}</span>
        <span>Modifié le {{ $receip->updated_at->format('d/m/Y à H:i') }}</span>
    </div>
</div>
@endsection