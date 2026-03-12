@extends('layouts.app')
@section('content')
<form action="{{ route('profile.employer.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nome Azienda</label>
        <input type="text" name="company_name" 
               value="{{ old('company_name', $user->profile?->company_name) }}" 
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Partita IVA</label>
        <input type="text" name="vat_number" 
               value="{{ old('vat_number', $user->profile?->vat_number) }}" 
               class="form-control">
    </div>
    
    @if($user->profile?->logo_path)
        <img src="{{ asset('storage/' . $user->profile->logo_path) }}" width="100">
    @endif

    <div class="mb-3">
        <label>Cambia Logo</label>
        <input type="file" name="logo" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Salva Modifiche</button>
</form>
@endsection