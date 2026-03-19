@extends('articles.layout')

@section('title', 'Modifier la ligne #' . $cart->id)

@section('content')
<div class="page-header">
    <div>
        <a href="{{ route('cart.show', $cart) }}" style="font-size:.85rem; color:var(--muted); text-decoration:none; display:inline-flex; align-items:center; gap:.3rem; margin-bottom:.6rem;">
            <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
            Retour au détail
        </a>
        <h1>Modifier la ligne</h1>
        <p>{{ $cart->article->name }}</p>
    </div>
</div>

<div class="card" style="padding: 1.75rem;">
    <form action="{{ route('cart.update', $cart) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-grid">

            {{-- Sélection article --}}
            <div class="form-group full">
                <label for="article_id">Article</label>
                <select id="article_id" name="article_id"
                        class="{{ $errors->has('article_id') ? 'invalid' : '' }}"
                        onchange="updatePreview(this)">
                    <option value="">— Sélectionner un article —</option>
                    @foreach ($articles as $article)
                        <option value="{{ $article->id }}"
                                data-price="{{ $article->price_ttc }}"
                                {{ old('article_id', $cart->article_id) == $article->id ? 'selected' : '' }}>
                            {{ $article->name }} — {{ number_format($article->price_ttc, 2, ',', ' ') }} € TTC
                            (stock : {{ $article->nb_stock }})
                        </option>
                    @endforeach
                </select>
                @error('article_id') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            {{-- Aperçu prix --}}
            <div class="form-group full" id="preview">
                <div style="padding: 1rem 1.25rem; background: var(--accent-light); border: 1px solid #dfc8b5; border-radius: var(--radius); display:flex; gap:2rem; align-items:center; flex-wrap:wrap;">
                    <div>
                        <div style="font-size:.75rem; font-weight:600; color:var(--muted); text-transform:uppercase; letter-spacing:.05em; margin-bottom:.2rem;">Prix unitaire TTC</div>
                        <div id="preview-price" style="font-family:'DM Serif Display',serif; font-size:1.4rem; color:var(--accent);">
                            {{ number_format($cart->article->price_ttc, 2, ',', ' ') }} €
                        </div>
                    </div>
                    <div>
                        <div style="font-size:.75rem; font-weight:600; color:var(--muted); text-transform:uppercase; letter-spacing:.05em; margin-bottom:.2rem;">Total estimé</div>
                        <div id="preview-total" style="font-family:'DM Serif Display',serif; font-size:1.4rem; color:var(--accent);">
                            {{ number_format($cart->total_price, 2, ',', ' ') }} €
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quantité --}}
            <div class="form-group">
                <label for="number">Quantité</label>
                <input type="number" id="number" name="number"
                       value="{{ old('number', $cart->number) }}"
                       min="1" step="1"
                       class="{{ $errors->has('number') ? 'invalid' : '' }}"
                       oninput="updateTotal()">
                @error('number') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{ route('cart.show', $cart) }}" class="btn btn-outline">Annuler</a>
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
</style>

<script>
let currentPrice = {{ $cart->article->price_ttc }};

function updatePreview(select) {
    const opt = select.options[select.selectedIndex];
    if (!opt.value) { currentPrice = 0; return; }
    currentPrice = parseFloat(opt.dataset.price);
    document.getElementById('preview-price').textContent = formatPrice(currentPrice);
    updateTotal();
}

function updateTotal() {
    const qty = parseInt(document.getElementById('number').value) || 1;
    document.getElementById('preview-total').textContent = formatPrice(currentPrice * qty);
}

function formatPrice(n) {
    return n.toFixed(2).replace('.', ',') + ' €';
}
</script>
@endsection