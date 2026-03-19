@extends('articles.layout')

@section('title', 'Modifier — ' . $article->name)

@section('content')
<div class="page-header">
    <div>
        <a href="{{ route('articles.show', $article) }}" style="font-size:.85rem; color:var(--muted); text-decoration:none; display:inline-flex; align-items:center; gap:.3rem; margin-bottom:.6rem;">
            <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
            Retour au détail
        </a>
        <h1>Modifier l'article</h1>
        <p>{{ $article->name }}</p>
    </div>
</div>

<div class="card" style="padding: 1.75rem;">
    <form action="{{ route('articles.update', $article) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-grid">

            {{-- Nom --}}
            <div class="form-group full">
                <label for="name">Nom de l'article</label>
                <input type="text" id="name" name="name"
                       value="{{ old('name', $article->name) }}"
                       class="{{ $errors->has('name') ? 'invalid' : '' }}">
                @error('name') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            {{-- Pays d'origine --}}
            <div class="form-group full">
                <label for="origin_country">Pays d'origine</label>
                <input type="text" id="origin_country" name="origin_country"
                       value="{{ old('origin_country', $article->origin_country) }}"
                       class="{{ $errors->has('origin_country') ? 'invalid' : '' }}">
                @error('origin_country') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            {{-- Stock --}}
            <div class="form-group">
                <label for="nb_stock">Quantité en stock</label>
                <input type="number" id="nb_stock" name="nb_stock"
                       value="{{ old('nb_stock', $article->nb_stock) }}"
                       min="0" step="1"
                       class="{{ $errors->has('nb_stock') ? 'invalid' : '' }}">
                @error('nb_stock') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            {{-- Prix unitaire --}}
            <div class="form-group">
                <label for="unit_price">Prix unitaire HT (€)</label>
                <input type="number" id="unit_price" name="unit_price"
                       value="{{ old('unit_price', $article->unit_price) }}"
                       min="0" step="0.01"
                       class="{{ $errors->has('unit_price') ? 'invalid' : '' }}">
                @error('unit_price') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            {{-- Remise --}}
            <div class="form-group">
                <label for="discount">Remise (%)</label>
                <input type="number" id="discount" name="discount"
                       value="{{ old('discount', $article->discount) }}"
                       min="0" max="100" step="0.01"
                       class="{{ $errors->has('discount') ? 'invalid' : '' }}">
                @error('discount') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            {{-- TVA --}}
            <div class="form-group">
                <label for="tva">TVA (%)</label>
                <input type="number" id="tva" name="tva"
                       value="{{ old('tva', $article->tva) }}"
                       min="0" max="100" step="0.01"
                       class="{{ $errors->has('tva') ? 'invalid' : '' }}">
                @error('tva') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            <a href="{{ route('articles.show', $article) }}" class="btn btn-outline">Annuler</a>
        </div>
    </form>
</div>
@endsection