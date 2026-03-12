@extends('layouts.app')

@section('content')
@if (session('verified'))
    <div class="alert alert-success">
        Email verificata con successo! Benvenuto nella nostra Job Board.
    </div>
@endif

<h2>Le tue candidature</h2>

@if ($applications->isEmpty())
<p>Non hai ancora mandato nessuna candidatura.</p>
@else
<table class="custom-table">
        <thead>
            <tr>
                <th>Azienda</th>
                <th>Stato candidatura</th>
                <th>Tipo</th>
            </tr>
        </thead>
        <tbody>
    @foreach ($applications  as $application)
        <tr>
                    <td class="font-bold text-slate-800">{{$application->employer_name}}</td>
                    <td>
                        {{ $application->status }}
                        <span class="badge {{ $application->status == 'accepted' ? 'bg-success' : ($application->status =='pending' ? 'bg-warning' : 'bg-danger') }}">
                        </span>
                    </td>
                    <td class="text-slate-500">{{ ucfirst($application->listing->work_type ?? 'N/D') }}</td>
        </tr>
    @endforeach
</tbody> </table>
@endif



@endsection

