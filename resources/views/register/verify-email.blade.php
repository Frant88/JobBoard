@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-4">Verifica il tuo indirizzo Email</h2>

    <div class="mb-4 text-sm text-gray-600">
        {{ ('Grazie per esserti registrato! Prima di iniziare, potresti verificare il tuo indirizzo email cliccando sul link che ti abbiamo appena inviato? Se non hai ricevuto l\'email, te ne invieremo volentieri un\'altra.') }}
    </div>


    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div>
                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{ ('Reinvia email di verifica') }}
                </button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="underline text-sm text-red-600 hover:text-red-800">
                {{('Log Out') }}
            </button>
        </form>
    </div>
</div>

@endsection