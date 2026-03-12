@extends('layouts.app')

@section('content')
<div class="container mt-4">
<div class="table-responsive">
<table class="custom-table">
        <thead>
            <tr>
                <th>Azienda</th>
                <th>Annuncio</th>
                <th>Descrizione</th>
                <th>location</th>
                <th>Tipo</th>
                <th>Attiva</th>
            </tr>
        </thead>
        <tbody>
        <tr>
                    <td class="font-bold text-slate-800">
                        {{$listing->user->profile->company_name}}
                    </td>
                     <td>
                        {{ $listing->title }}
                    </td>
                    <td>
                        {{ $listing->description }}
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
</tbody> 
</table>
           <form action="{{ route('application.store', $listing) }}" method="POST" class="mt-4">
    @csrf
    <div class="mb-3">
        <label for="cover_letter" class="form-label">Lettera di presentazione (opzionale)</label>
        <textarea name="cover_letter" id="cover_letter" rows="5" class="form-control" placeholder="Raccontaci perché sei il candidato ideale..."></textarea>
    </div>
    <button type="submit" class="btn btn-primary w-100">Invia Candidatura</button>
</form>


</div>
</div>

@endsection