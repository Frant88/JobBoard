@extends('layouts.app')

@section('content')
<div class="container mt-4">
<div class="table-responsive">
            <label>Cerca per categoria</label>
            <input type="text" name="location_search" id = "location_search" required placeholder="Inizia a scrivere" autocomplete="off">
            <ul id="suggestions-list" style="display:none;" class="list-group position-absolute w-100 shadow-sm"></ul>

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
        <tr onclick="window.location='{{ route('listing.show',$listing->slug) }}'" style="cursor: pointer;">
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
</tbody> 
</table>
</div>
<div class="mt-4">
    {{ $listings->links() }}
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded',()=>{
        const input = document.querySelector('#location_search');
        const list = document.querySelector('#suggestions-list');

        let citta= [];

        fetch('/api/listings/city')
        .then(res=>res.json())
        .then(data=>{
            citta = data;
        });

        input.addEventListener('input', ()=>{
            const query= input.value.toLowerCase();
            list.innerHTML = "";

            if(query.length < 1){
                list.style.display = "none";
                return;
            }

            const filtered = [...new Set(
                citta.filter(c => c.location.toLowerCase().includes(query))
                     .map(c => c.location)
            )].slice(0, 10);
                
            if(filtered.length >0){
                filtered.forEach(cit =>{
                    const li = document.createElement('li')
                    li.className = 'list-group-item list-group-item-action';
                    li.style.cursor = 'pointer';
                    li.textContent = cit;

                    li.onclick = ()=>{
                        input.value = cit;
                        list.style.display = 'none';

                        window.location.href= `/listings?location_search=${encodeURIComponent(cit)}`
                        console.log(cit);
                    };
                    list.appendChild(li);
                });
              list.style.display = 'block';  
            }else {
            list.style.display = 'none';
        }
        });
    })
</script>

@endsection