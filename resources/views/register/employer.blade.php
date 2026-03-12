@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Registrazione Azienda</h2>
    <form action="{{ route('register.employer.store') }}" method="POST">
        @csrf
        
        {{-- Dati Referente/Account --}}
        <div>
            <label>Nome Referente</label>
            <input type="text" name="name" required value="{{ old('name') }}">
        </div>

        <div>
            <label>Email Aziendale</label>
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

        {{-- Dati Azienda --}}
        <div>
            <label>Nome dell'Azienda</label>
            <input type="text" name="company_name" required value="{{ old('company_name') }}">
        </div>

        <div>
            <label>Partita IVA</label>
            <input type="text" name="vat_number" required value="{{ old('vat_number') }}">
        </div>

        <button type="submit">Registrati come Azienda</button>
    </form>
</div>
@endsection