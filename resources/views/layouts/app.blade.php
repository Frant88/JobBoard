<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'JobPlatform') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body { background-color: #f8f9fa; }
        .navbar { margin-bottom: 30px; }
        .footer { margin-top: 50px; padding: 20px; background: #fff; text-align: center; }

        /* Container della tabella*/
.table-container {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    padding: 20px;
    margin-top: 20px;
}


.custom-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 8px; 
}

.custom-table thead th {
    background-color: #f8f9fa;
    color: #6c757d;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 1px;
    padding: 15px;
    border: none;
}


.custom-table tbody tr {
    background-color: #ffffff;
    transition: all 0.3s ease;
    box-shadow: 0 2px 5px rgba(0,0,0,0.02);
}

.custom-table tbody td {
    padding: 15px;
    vertical-align: middle;
    border-top: 1px solid #f1f1f1;
    border-bottom: 1px solid #f1f1f1;
}


.custom-table tbody tr td:first-child {
    border-left: 1px solid #f1f1f1;
    border-top-left-radius: 8px;
    border-bottom-left-radius: 8px;
}

.custom-table tbody tr td:last-child {
    border-right: 1px solid #f1f1f1;
    border-top-right-radius: 8px;
    border-bottom-right-radius: 8px;
}


.custom-table tbody tr:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    background-color: #fdfdfd;
}


.badge {
    padding: 8px 12px;
    border-radius: 6px;
    font-weight: 500;
}
    </style>
</head>
<body>

    

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="{{ route('home') }}">JobBoard</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" href="{{ route('home') }}">Home</a>
        </li>
        
        @guest
            <li class="nav-item">
              <a class="nav-link" href="{{ route('register.candidate') }}">Registrati come Candidato</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('register.employer') }}">Registrati come Azienda</a>
            </li>
            <li class="nav-item">
              <a class="btn btn-outline-light ms-lg-2" href="{{route('login') }}">Login</a>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link text-info" href="{{ route ('profile') }}">{{ Auth::user()->name }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ route ('dashboard') }}">Dashboard</a>
            </li>
        @if (Auth::user()->is_employer )
             <li class="nav-item">
                <a class="nav-link active" href="{{ route ('listings.show') }}">Crea annuncio</a>
            </li>
        @elseif (!Auth::user()->is_employer)
            <li class="nav-item">
                <a class="nav-link active" href="{{ route ('listings.candidate.show') }}">Annunci</a>
            </li>
        @endif
          <li class="nav-item">
                <a class="nav-link active" href="{{ route ('chats') }}">Chat</a>
            </li>
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link">Logout</button>
                </form>
            </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>

    <main class="py-4">
        @if (session('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
        @endif
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="footer border-top">
        <div class="container">
            <span class="text-muted">© 2026 JobPlatform - Portfolio Project</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>