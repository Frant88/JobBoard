@extends('layouts.app')

@section('content')
<div class="container mt-4">
    @if (session('verified'))
    <div class="alert alert-success">
        Email verificata con successo! Benvenuto nella nostra Job Board.
    </div>
@endif
    <h2>I tuoi Annunci</h2>

@if ($listings->isEmpty())
<p>Non hai ancora pubblicato un annuncio.</p>
@else
<div class="table-responsive">
<table class="custom-table">
        <thead>
            <tr>
                <th>Annuncio</th>
                <th>location</th>
                <th>Tipo</th>
                <th>Richieste candidati</th>
                <th>Attiva</th>
            </tr>
        </thead>
        <tbody>
    @foreach ($listings  as $listing)
        <tr onclick="window.location='{{ route('listing.show',$listing->slug) }}'" style="cursor: pointer;">
                    <td class="font-bold text-slate-800">
                        {{$listing->title}}
                    </td>
                    <td>
                        {{ $listing->location }}
                    </td>
                     <td>
                       {{ ucfirst($listing->work_type ?? 'N/D') }}
                    </td>
                     <td>
                       {{ $listing->applications_count }}
                    </td>
                    <td class="text-slate-500">
                        
                        <span class="badge {{ $listing->is_active == '1' ? 'bg-success' :  'bg-danger' }}">
                        </span>
                    </td>
        </tr>
    @endforeach
</tbody> </table>
</div>
@endif
</div>

@endsection
