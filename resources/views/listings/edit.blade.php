@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Modifica</h2>
    <form action="{{ route('listing.update',$listing) }}" method="POST">
        @csrf
        @method('PUT')
    </div>  
        

        <div>
            <label>Titolo</label>
            <input type="text" name="title" required value="{{ $listing->title }}">
        </div>

        <div>
            <label>Descrizione</label>
            <input type="textarea" name="description" required value="{{ $listing->description }}">
        </div>

       <select id="work_type" name="work_type" class="input-style" required>
    <option value="" disabled>Seleziona una modalità...</option>
    
    <option value="onsite" {{ $listing->work_type == 'onsite' ? 'selected' : '' }}>
        In sede
    </option>
    
    <option value="hybrid" {{ $listing->work_type == 'hybrid' ? 'selected' : '' }}>
        Ibrido
    </option>
    
    <option value="remote" {{ $listing->work_type == 'remote' ? 'selected' : '' }}>
        Da remoto
    </option>
</select>

        <button type="submit">Aggiorna</button>
    </form>
</div>
@endsection