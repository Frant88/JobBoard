@extends('layouts.app')
@section('content')
<h1>{{ $user->name }}</h1>
<form action="{{ route('profile.candidate.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Email</label>
        <input type="text" name="email" 
               value="{{ old('email', $user->email) }}" 
               placeholder="{{ $user->profile?->company_name }}"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Bio</label>
        <input type="textterea" name="bio" 
               value="{{ old('bio', $user->profile?->bio) }}" 
               class="form-control">
    </div>
    
    @if($user->profile?->logo_path)
        <img src="{{ asset('storage/' . $user->profile->logo_path) }}" width="100">
    @endif

    <div class="mb-3">
        <label>Cambia Logo</label>
        <input type="file" name="logo" class="form-control">
    </div>

     @if($user->profile?->cv_path)
        <img src="{{ asset('storage/' . $user->profile->cv_path) }}" width="100">
    @endif

    <div class="mb-3">
        <label>CV</label>
        <input type="file" name="cv_path" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Salva Modifiche</button>
</form>
@endsection
