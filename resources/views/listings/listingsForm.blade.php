@extends('layouts.app')
@section('content')



<div class="container">
    <h2>Pubblica un annuncio</h2>
    <form action="{{ route('listings.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div>
            <label>Posizione lavorativa</label>
            <input type="text" name="title" required value="{{ old('title') }}" placeholder="Senior Laravel Developer">
            <small>Questo sarà il titolo principale del tuo annuncio.</small>
        </div>

        <div>
            <label>Categoria</label>
            <input type="text" name="category_search" id = "category_search" required placeholder="Inizia a scrivere" autocomplete="off">
            <input type="hidden" name="category_id" id="category_id">
            <ul id="suggestions-list" style="display:none;"></ul>
        </div>

        <div>
            <label>Descrizione</label>
            <input type="text" name="description" required value="{{ old('description') }}">
        </div>

        <div>
            <label>Sede</label>
            <input type="text" name="location" required value="{{ old('location') }}">
        </div>

        <div class="form-group">
        <label for="work_type" class="label-style">
            Modalità di lavoro
        </label>

        <select 
            id="work_type" 
            name="work_type" 
            class="input-style"
            required
        >
            <option value="" disabled selected>Seleziona una modalità...</option>
            
            <option value="onsite">In sede </option>
            <option value="hybrid">Ibrido </option>
            <option value="remote">Da remoto </option>
        </select>

        <p class="helper-text">Specifica se il lavoro richiede la presenza fisica o è flessibile.</p>
        </div>

                <button type="submit">Crea annuncio</button>
            </form>
        </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('category_search');
    const list = document.getElementById('suggestions-list');
    const hiddenInput = document.getElementById('category_id');
    
    let categories = [];

    // 1. Carichiamo i dati dalla API
    fetch('/api/categories')
        .then(res => res.json())
        .then(data => {
            categories = data;
        });

    // 2. Filtriamo mentre l'utente scrive
    input.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        list.innerHTML = ''; // Puliamo la lista precedente

        if (query.length < 2) {
            list.style.display = 'none';
            return;
        }

        const filtered = categories.filter(c => 
            c.name.toLowerCase().includes(query)
        ).slice(0, 10); // Ne mostriamo max 10

        if (filtered.length > 0) {
            filtered.forEach(cat => {
                const li = document.createElement('li');
                li.className = 'list-group-item list-group-item-action';
                li.style.cursor = 'pointer';
                li.textContent = cat.name;
                
                // Quando clicchi su una categoria
                li.onclick = () => {
                    input.value = cat.name;       // Metti il nome nell'input
                    hiddenInput.value = cat.id;   // Metti l'ID nell'input nascosto
                    list.style.display = 'none';  // Chiudi la lista
                };
                list.appendChild(li);
            });
            list.style.display = 'block';
        } else {
            list.style.display = 'none';
        }
    });

    // Chiudi la lista se clicchi fuori
    document.addEventListener('click', (e) => {
        if (e.target !== input) list.style.display = 'none';
    });
});
    </script>

@endsection