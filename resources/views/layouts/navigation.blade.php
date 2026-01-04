<nav class="clash-nav">
    <div class="nav-content">
        <div class="logo">
            <a href="{{ route('home') }}">👑 ClashDeck</a>
        </div>

        <div class="links">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Galerie des decks</a>
            <a href="{{ route('cards.index') }}" class="{{ request()->routeIs('cards.*') ? 'active' : '' }}">Cartes</a>
            
            @auth
                <a href="{{ route('decks.my') }}" class="{{ request()->routeIs('decks.*') ? 'active' : '' }}">Mes Decks</a>
                
                <div class="user-menu">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <a href="{{ route('profile.edit') }}" class="btn-account">Profil</a>
                    
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn-logout">Déconnexion</button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}">Connexion</a>
                <a href="{{ route('register') }}">Inscription</a>
            @endauth
        </div>
    </div>

    <style>
        .clash-nav { background-color: #333; border-bottom: 4px solid #b22222; padding: 15px 20px; color: white; position: sticky; top: 0; z-index: 50; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .nav-content { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .logo a { font-family: 'Bangers', cursive; font-size: 1.8rem; color: #f1c40f; letter-spacing: 1px; text-decoration: none; text-shadow: 2px 2px #000; }
        .links { display: flex; align-items: center; gap: 20px; }
        .links a { text-decoration: none; color: white; font-weight: bold; font-family: 'Verdana', sans-serif; font-size: 0.95rem; transition: color 0.2s; }
        .links a:hover, .links a.active { color: #f1c40f; }
        .user-menu { display: flex; align-items: center; gap: 15px; background: rgba(255,255,255,0.1); padding: 5px 15px; border-radius: 30px; border: 1px solid #555; }
        .user-name { color: #f1c40f; font-weight: bold; font-size: 0.9rem; }
        .btn-account { background: #b22222; padding: 5px 12px; border-radius: 5px; font-size: 0.85rem !important; }
        .btn-account:hover { background: #d00000; }
        .btn-logout { background: none; border: none; color: #aaa; cursor: pointer; font-weight: bold; font-size: 0.85rem; text-decoration: underline; padding: 0; }
        .btn-logout:hover { color: white; }
        @media (max-width: 768px) { .nav-content { flex-direction: column; gap: 15px; } .user-menu { flex-direction: column; gap: 10px; background: none; border: none; } }
    </style>
</nav>