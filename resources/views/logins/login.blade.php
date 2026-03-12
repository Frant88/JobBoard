@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Login</h2>
    <form action="{{ route('login.store') }}" method="POST">
        @csrf
        
        </ul>
    </div>  
        

        <div>
            <label>Email</label>
            <input type="email" name="email" required value="{{ old('email') }}">
        </div>

        <div>
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-group">
            <input type="checkbox" name="remember" id="remember">
             <label for="remember">Ricordami su questo dispositivo</label>
        </div>

        <button type="submit">Login</button>
    </form>
</div>
@endsection