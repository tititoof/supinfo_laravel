@extends('articles.layout')

@section('title', 'Nouveau reçu')

@section('content')
<div class="page-header">
    <div>
        <a href="{{ route('receips.index') }}" style="font-size:.85rem; color:var(--muted); text-decoration:none; display:inline-flex; align-items:center; gap:.3rem; margin-bottom:.6rem;">
            <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
            Retour aux reçus
        </a>
        <h1>Nouveau reçu</h1>
        <p>Associer un reçu à un utilisateur</p>
    </div>
</div>

<div class="card" style="padding: 1.75rem;">
    <form action="{{ route('receips.store') }}" method="POST">
        @csrf
        <div class="form-grid">

            <div class="form-group full">
                <label for="users_id">Utilisateur</label>
                <select id="users_id" name="users_id"
                        class="{{ $errors->has('users_id') ? 'invalid' : '' }}">
                    <option value="">— Sélectionner un utilisateur —</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}"
                                {{ old('users_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('users_id') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Créer le reçu</button>
            <a href="{{ route('receips.index') }}" class="btn btn-outline">Annuler</a>
        </div>
    </form>
</div>

<style>
select {
    width: 100%;
    padding: .65rem .9rem;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    font-family: inherit;
    font-size: .9rem;
    background: var(--bg);
    color: var(--text);
    transition: border-color .15s, box-shadow .15s;
    outline: none;
    cursor: pointer;
}
select:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(196,98,45,.12);
    background: #fff;
}
select.invalid { border-color: var(--danger); }
</style>
@endsection