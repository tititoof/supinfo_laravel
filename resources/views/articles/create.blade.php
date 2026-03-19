@extends('articles.layout')

@section('title', 'Nouvel article')

@section('content')
<div class="page-header">
    <div>
        <a href="{{ route('articles.index') }}" style="font-size:.85rem; color:var(--muted); text-decoration:none; display:inline-flex; align-items:center; gap:.3rem; margin-bottom:.6rem;">
            <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
            Retour à la liste
        </a>
        <h1>Nouvel article</h1>
        <p>Remplissez les informations ci-dessous</p>
    </div>
</div>

<div class="card" style="padding: 1.75rem;">
    <form action="{{ route('articles.store') }}" method="POST">
        @csrf
        <div class="form-grid">

            {{-- Nom --}}
            <div class="form-group full">
                <label for="name">Nom de l'article</label>
                <input type="text" id="name" name="name"
                       value="{{ old('name') }}"
                       class="{{ $errors->has('name') ? 'invalid' : '' }}"
                       placeholder="Ex: Tomate cerise bio">
                @error('name') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            {{-- Pays d'origine --}}
            <div class="form-group full">
                <label for="origin_country">Pays d'origine</label>
                <input type="text" id="origin_country" name="origin_country"
                       value="{{ old('origin_country') }}"
                       class="{{ $errors->has('origin_country') ? 'invalid' : '' }}"
                       placeholder="Ex: France">
                @error('origin_country') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            {{-- Stock --}}
            <div class="form-group">
                <label for="nb_stock">Quantité en stock</label>
                <input type="number" id="nb_stock" name="nb_stock"
                       value="{{ old('nb_stock', 0) }}"
                       min="0" step="1"
                       class="{{ $errors->has('nb_stock') ? 'invalid' : '' }}">
                @error('nb_stock') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            {{-- Prix unitaire --}}
            <div class="form-group">
                <label for="unit_price">Prix unitaire HT (€)</label>
                <input type="number" id="unit_price" name="unit_price"
                       value="{{ old('unit_price') }}"
                       min="0" step="0.01"
                       class="{{ $errors->has('unit_price') ? 'invalid' : '' }}"
                       placeholder="0.00">
                @error('unit_price') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            {{-- Remise --}}
            <div class="form-group">
                <label for="discount">Remise (%)</label>
                <input type="number" id="discount" name="discount"
                       value="{{ old('discount', 0) }}"
                       min="0" max="100" step="0.01"
                       class="{{ $errors->has('discount') ? 'invalid' : '' }}">
                <span class="hint">Entre 0 et 100</span>
                @error('discount') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            {{-- TVA --}}
            <div class="form-group">
                <label for="tva">TVA (%)</label>
                <input type="number" id="tva" name="tva"
                       value="{{ old('tva', 20) }}"
                       min="0" max="100" step="0.01"
                       class="{{ $errors->has('tva') ? 'invalid' : '' }}">
                <span class="hint">Ex: 20 pour 20%</span>
                @error('tva') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Créer l'article</button>
            <a href="{{ route('articles.index') }}" class="btn btn-outline">Annuler</a>
        </div>
    </form>
</div>
@endsection