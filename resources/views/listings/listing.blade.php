@extends('layouts.app')

@section('content')

<h1>{{ $listing->title }}</h1>

  <a href="{{ route('listings.edit', $listing) }}" class="btn btn-warning">
    Modifica Annuncio
</a>

<div class="mb-3">
    <button onclick="filterTable('all')" class="btn btn-secondary">Tutti</button>
    <button onclick="filterTable('pending')" class="btn btn-warning">In Attesa</button>
    <button onclick="filterTable('accepted')" class="btn btn-success">Accettati</button>
    <button onclick="filterTable('rejected')" class="btn btn-danger">Rifiutati</button>
</div>

<div class="table-responsive">
<table class="custom-table" id="applicationsTable">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Cv</th>
                <th>Lettera</th>
                <th>Stato Candidatura</th>
            </tr>
        </thead>
        <tbody>
    @foreach ($applications  as $application)
        <tr data-status="{{ $application->status }}">
                    <td class="font-bold text-slate-800">
                        {{$application->user->name}}
                    </td>
                    <td>
                        {{ $application->user->email }}
                    </td>
                     <td>
                       <a href="{{ asset('storage/' . $application->user->profile->cv_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            Visualizza CV
                       </a>
                    </td>
                     <td>
                    {{ Str::limit($application->cover_letter, 50) }}
                       {{ $application->cover_letter }}
                    </td>
                    @if ($application->status != 'pending')
                        <td>
                            {{ $application->status }}
                        </td>
                    @else
                        <td>
                        <form action="{{ route('application.accepted', $application) }}" method="POST" class="mt-4">
                            @csrf
                            @method('PUT')
                            
                            <button type="submit" class="btn btn-success w-100">Accetta</button>
                        </form>
                        <form action="{{ route('application.rejected', $application) }}" method="POST" class="mt-4">
                            @csrf
                            @method('PUT')
                            
                            <button type="submit" class="btn btn-danger w-100">Rifiuta</button>
                        </form>
                        </td>
                    @endif
                    
        </tr>
    @endforeach
</tbody> </table>
</div>

@endsection


<script>
function filterTable(status) {
    const rows = document.querySelectorAll('#applicationsTable tbody tr');

    rows.forEach(row => {
        const rowStatus = row.getAttribute('data-status');

        if (status === 'all' || rowStatus === status) {
            row.style.display = ''; // Mostra la riga
        } else {
            row.style.display = 'none'; // Nascondi la riga
        }
    });
}
</script>