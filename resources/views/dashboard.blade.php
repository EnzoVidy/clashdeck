<x-app-layout>
    <div class="dashboard-container">
        <div class="welcome-banner">
            <h1>Bienvenue, {{ Auth::user()->name }} !</h1>
            <p>Prêt à construire le deck ultime ?</p>
        </div>

        <div class="menu-grid">
            
            <a href="{{ route('decks.my') }}" class="menu-card">
                <div class="icon">🎴</div>
                <h3>Mes Decks</h3>
                <p>Gérez vos compositions.</p>
            </a>

            <a href="{{ route('decks.create') }}" class="menu-card">
                <div class="icon">➕</div>
                <h3>Nouveau Deck</h3>
                <p>Créer une nouvelle stratégie.</p>
            </a>

            <a href="{{ route('profile.edit') }}" class="menu-card">
                <div class="icon">🤴</div>
                <h3>Mon Profil</h3>
                <p>Modifier Tag et Bio.</p>
            </a>
        </div>
    </div>

    <style>
        .dashboard-container { max-width: 1000px; margin: 40px auto; padding: 0 20px; }
        
        .welcome-banner { background-color: #b22222; color: white; padding: 30px; border-radius: 10px; text-align: center; margin-bottom: 30px; border-bottom: 5px solid #800000; }
        .welcome-banner h1 { margin: 0; font-family: 'Verdana', sans-serif; font-size: 2em; }
        
        .menu-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        
        .menu-card { background: white; padding: 30px; border-radius: 10px; text-align: center; text-decoration: none; color: #333; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border: 2px solid transparent; transition: 0.3s; }
        .menu-card:hover { border-color: #f1c40f; transform: translateY(-5px); }
        
        .icon { font-size: 3em; margin-bottom: 15px; }
        .menu-card h3 { color: #b22222; margin: 0 0 10px 0; }
        .menu-card p { color: #666; font-size: 0.9em; }
    </style>
</x-app-layout>