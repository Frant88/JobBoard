@extends('layouts.app')

@section('content')
<div class="container mt-4">
<div class="table-responsive">
    <form actrion={{ route('home') }} method= 'GET'>
            <label>Cerca per categoria</label>
            <input type="text" name="category_search" id = "category_search" required placeholder="Inizia a scrivere" autocomplete="off">
            <input type="hidden" name="category_id" id="category_id">
            <ul id="suggestions-list" style="display:none;" class="list-group position-absolute w-100 shadow-sm"></ul>

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                    Cerca
                </button>
    </form>
<table class="custom-table">
        <thead>
            <tr>
                <th>Azienda</th>
                <th>Annuncio</th>
                <th>location</th>
                <th>Tipo</th>
                <th>Attiva</th>
            </tr>
        </thead>
        <tbody>
    @foreach ($listings  as $listing)
        <tr>
                    <td class="font-bold text-slate-800">
                        {{$listing->user->profile->company_name}}
                    </td>
                     <td>
                        {{ $listing->title }}
                    </td>
                    <td>
                        {{ $listing->location }}
                    </td>
                     <td>
                       {{ ucfirst($listing->work_type ?? 'N/D') }}
                    </td>
                    <td class="text-slate-500">
                        
                        <span class="badge {{ $listing->is_active == '1' ? 'bg-success' :  'bg-danger' }}">
                        </span>
                    </td>
        </tr>
    @endforeach
</tbody> </table>
</div>
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

        if (query.length < 1) {
            list.style.display = 'none';
            return;
        }

        const filtered = categories.filter(function(c) {
            return c && c.name && c.name.toLowerCase().indexOf(query) !== -1;
            }).slice(0, 10); // Ne mostriamo max 10

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

                    window.location.href='/?category_id=' + cat.id;
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