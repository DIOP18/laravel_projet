<nav class="navbar navbar-expand-lg" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); padding: 1rem; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15); margin-bottom: 20px;">
    <div class="container">
        <a class="navbar-brand text-white fw-bold" href="#">
            <i class="fas fa-book-open me-2"></i> MISSTECH LIBRAIRIE
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
                @if(Auth::user()->role == 'client')
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center mx-2 fw-semibold" href="{{ url('/catalogue') }}">
                            <i class="fas fa-list me-2"></i> Catalogues
                        </a>
                    </li>
                @endif
                @if(Auth::user()->role == 'gestionnaire')
                    <li class="nav-item">

                        <a class="nav-link text-white d-flex align-items-center mx-2 fw-semibold" href="{{ url('/livre') }}">
                            <i class="fas fa-book me-2"></i> Gestion des Produits
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center mx-2 fw-semibold" href="{{ url('/index') }}">
                            <i class="fas fa-shopping-cart me-2"></i> Gestion des Commandes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center mx-2 fw-semibold" href="{{ url('/statistique') }}">
                            <i class="fas fa-chart-bar me-2"></i> Statistiques et Rapportss
                        </a>
                    </li>
                @endif
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link text-danger d-flex align-items-center mx-2 fw-semibold" style="border: none; background: none; cursor: pointer;">
                                <i class="fas fa-window-close me-2"></i> Se Déconnecter
                            </button>
                        </form>
                    </li>



            </ul>
        </div>
    </div>
</nav>

<div style="padding-top: 20px;">
    @yield("navbar")
</div>
