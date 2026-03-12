@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Registrazione Candidato</h2>
    <form action="{{ route('register.candidate.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        {{-- Dati Utente --}}
        <div>
            <label>Nome Completo</label>
            <input type="text" name="name" required value="{{ old('name') }}">
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email" required value="{{ old('email') }}">
        </div>

        <div>
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <div>
            <label>Conferma Password</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <hr>

        {{-- Dati Profilo Candidato --}}
        <div>
            <label>Link GitHub (Opzionale)</label>
            <input type="url" name="github_url" value="{{ old('github_url') }}">
        </div>

        <div>
            <label>Carica il tuo CV (Solo PDF)</label>
            <input type="file" name="cv_path" accept=".pdf">
        </div>

        <button type="submit">Registrati come Candidato</button>
    </form>
</div>
@endsection
