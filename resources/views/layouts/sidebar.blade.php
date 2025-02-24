<div id="sidebar" class="sidebar p-3">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('domains.index') }}"><i class="bi bi-globe2"></i> Meus Domínios</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('profile.index') }}"><i class="bi bi-person"></i> Perfil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i> Sair
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</div>
