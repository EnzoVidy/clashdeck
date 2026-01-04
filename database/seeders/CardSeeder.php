<?php

namespace Database\Seeders;

use App\Models\Card;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CardSeeder extends Seeder
{
    /**
     * Exécute le seeder de la base de données.
     *
     * Parcourt une liste prédéfinie de cartes Clash Royale, télécharge leurs
     * images depuis un dépôt distant si elles sont manquantes, et synchronise
     * les enregistrements en base de données.
     */
    public function run(): void
    {
        // URL de base pour la récupération des images (Github RoyaleAPI)
        $baseUrl = 'https://raw.githubusercontent.com/RoyaleAPI/cr-api-assets/master/cards/';

        // Liste exhaustive des cartes à insérer
        $cards = [
            // --- COMMUNES ---
            ['name' => 'Chevalier',         'slug' => 'knight',           'elixir' => 3, 'rarity' => 'Commune', 'arena' => 1],
            ['name' => 'Archers',           'slug' => 'archers',          'elixir' => 3, 'rarity' => 'Commune', 'arena' => 1],
            ['name' => 'Goblins',           'slug' => 'goblins',          'elixir' => 2, 'rarity' => 'Commune', 'arena' => 1],
            ['name' => 'Géant Royal',       'slug' => 'royal-giant',      'elixir' => 6, 'rarity' => 'Commune', 'arena' => 7],
            ['name' => 'Squelettes',        'slug' => 'skeletons',        'elixir' => 1, 'rarity' => 'Commune', 'arena' => 2],
            ['name' => 'Gargouilles',       'slug' => 'minions',          'elixir' => 3, 'rarity' => 'Commune', 'arena' => 2],
            ['name' => 'Barbares',          'slug' => 'barbarians',       'elixir' => 5, 'rarity' => 'Commune', 'arena' => 3],
            ['name' => 'Barbares d\'élite', 'slug' => 'elite-barbarians', 'elixir' => 6, 'rarity' => 'Commune', 'arena' => 10],
            ['name' => 'Esprit de glace',   'slug' => 'ice-spirit',       'elixir' => 1, 'rarity' => 'Commune', 'arena' => 8],
            ['name' => 'Chauve-souris',     'slug' => 'bats',             'elixir' => 2, 'rarity' => 'Commune', 'arena' => 5],
            ['name' => 'Zap',               'slug' => 'zap',              'elixir' => 2, 'rarity' => 'Commune', 'arena' => 5],
            ['name' => 'Flèches',           'slug' => 'arrows',           'elixir' => 3, 'rarity' => 'Commune', 'arena' => 1],
            ['name' => 'Canon',             'slug' => 'cannon',           'elixir' => 3, 'rarity' => 'Commune', 'arena' => 3],
            ['name' => 'Mortier',           'slug' => 'mortar',           'elixir' => 4, 'rarity' => 'Commune', 'arena' => 6],
            ['name' => 'Tesla',             'slug' => 'tesla',            'elixir' => 4, 'rarity' => 'Commune', 'arena' => 11],

            // --- RARES ---
            ['name' => 'Géant',             'slug' => 'giant',            'elixir' => 5, 'rarity' => 'Rare', 'arena' => 1],
            ['name' => 'Mousquetaire',      'slug' => 'musketeer',        'elixir' => 4, 'rarity' => 'Rare', 'arena' => 1],
            ['name' => 'Mini P.E.K.K.A',    'slug' => 'mini-pekka',       'elixir' => 4, 'rarity' => 'Rare', 'arena' => 1],
            ['name' => 'Valkyrie',          'slug' => 'valkyrie',         'elixir' => 4, 'rarity' => 'Rare', 'arena' => 2],
            ['name' => 'Chevaucheur de cochon', 'slug' => 'hog-rider',    'elixir' => 4, 'rarity' => 'Rare', 'arena' => 5],
            ['name' => 'Sorcier',           'slug' => 'wizard',           'elixir' => 5, 'rarity' => 'Rare', 'arena' => 5],
            ['name' => 'Bélier de combat',  'slug' => 'battle-ram',       'elixir' => 4, 'rarity' => 'Rare', 'arena' => 10],
            ['name' => 'Golem de glace',    'slug' => 'ice-golem',        'elixir' => 2, 'rarity' => 'Rare', 'arena' => 8],
            ['name' => 'Méga Gargouille',   'slug' => 'mega-minion',      'elixir' => 3, 'rarity' => 'Rare', 'arena' => 7],
            ['name' => 'Boule de feu',      'slug' => 'fireball',         'elixir' => 4, 'rarity' => 'Rare', 'arena' => 1],
            ['name' => 'Tour de l\'enfer',  'slug' => 'inferno-tower',    'elixir' => 5, 'rarity' => 'Rare', 'arena' => 4],
            ['name' => 'Machine volante',   'slug' => 'flying-machine',   'elixir' => 4, 'rarity' => 'Rare', 'arena' => 9],
            ['name' => 'Zappies',           'slug' => 'zappies',          'elixir' => 4, 'rarity' => 'Rare', 'arena' => 11],

            // --- ÉPIQUES ---
            ['name' => 'Prince',            'slug' => 'prince',           'elixir' => 5, 'rarity' => 'Épique', 'arena' => 7],
            ['name' => 'Bébé Dragon',       'slug' => 'baby-dragon',      'elixir' => 4, 'rarity' => 'Épique', 'arena' => 2],
            ['name' => 'Armée de squelettes', 'slug' => 'skeleton-army',  'elixir' => 3, 'rarity' => 'Épique', 'arena' => 2],
            ['name' => 'Sorcière',          'slug' => 'witch',            'elixir' => 5, 'rarity' => 'Épique', 'arena' => 2],
            ['name' => 'P.E.K.K.A',         'slug' => 'pekka',            'elixir' => 7, 'rarity' => 'Épique', 'arena' => 4],
            ['name' => 'Golem',             'slug' => 'golem',            'elixir' => 8, 'rarity' => 'Épique', 'arena' => 6],
            ['name' => 'Ballon',            'slug' => 'balloon',          'elixir' => 5, 'rarity' => 'Épique', 'arena' => 6],
            ['name' => 'Squelette Géant',   'slug' => 'giant-skeleton',   'elixir' => 6, 'rarity' => 'Épique', 'arena' => 4],
            ['name' => 'Prince Ténébreux',  'slug' => 'dark-prince',      'elixir' => 4, 'rarity' => 'Épique', 'arena' => 7],
            ['name' => 'Foudre',            'slug' => 'lightning',        'elixir' => 6, 'rarity' => 'Épique', 'arena' => 8],
            ['name' => 'Tornade',           'slug' => 'tornado',          'elixir' => 3, 'rarity' => 'Épique', 'arena' => 12],
            ['name' => 'Poison',            'slug' => 'poison',           'elixir' => 4, 'rarity' => 'Épique', 'arena' => 9],
            ['name' => 'Arc-X',             'slug' => 'x-bow',            'elixir' => 6, 'rarity' => 'Épique', 'arena' => 6],
            ['name' => 'Bourreau',          'slug' => 'executioner',      'elixir' => 5, 'rarity' => 'Épique', 'arena' => 14],

            // --- LÉGENDAIRES ---
            ['name' => 'La Bûche',          'slug' => 'the-log',          'elixir' => 2, 'rarity' => 'Légendaire', 'arena' => 6],
            ['name' => 'Princesse',         'slug' => 'princess',         'elixir' => 3, 'rarity' => 'Légendaire', 'arena' => 5],
            ['name' => 'Sorcier de glace',  'slug' => 'ice-wizard',       'elixir' => 3, 'rarity' => 'Légendaire', 'arena' => 8],
            ['name' => 'Electro-Sorcier',   'slug' => 'electro-wizard',   'elixir' => 4, 'rarity' => 'Légendaire', 'arena' => 11],
            ['name' => 'Mineur',            'slug' => 'miner',            'elixir' => 3, 'rarity' => 'Légendaire', 'arena' => 4],
            ['name' => 'Voleuse',           'slug' => 'bandit',           'elixir' => 3, 'rarity' => 'Légendaire', 'arena' => 9],
            ['name' => 'Méga Chevalier',    'slug' => 'mega-knight',      'elixir' => 7, 'rarity' => 'Légendaire', 'arena' => 7],
            ['name' => 'Molosse de lave',   'slug' => 'lava-hound',       'elixir' => 7, 'rarity' => 'Légendaire', 'arena' => 10],
            ['name' => 'Archer Magique',    'slug' => 'magic-archer',     'elixir' => 4, 'rarity' => 'Légendaire', 'arena' => 13],
            ['name' => 'Sparky',            'slug' => 'sparky',           'elixir' => 6, 'rarity' => 'Légendaire', 'arena' => 11],

            // --- CHAMPIONS ---
            ['name' => 'Reine des Archers', 'slug' => 'archer-queen',     'elixir' => 5, 'rarity' => 'Champion', 'arena' => 16],
        ];

        // S'assurer que le répertoire de stockage existe
        Storage::disk('public')->makeDirectory('cards');

        // Configuration du contexte de flux pour contourner les restrictions strictes (SSL/Headers)
        $context = stream_context_create([
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false,
            ],
            "http" => [
                "header" => "User-Agent: LaravelScript/1.0"
            ]
        ]);

        foreach ($cards as $data) {
            $imageName = $data['slug'] . '.png';
            $localPath = 'cards/' . $imageName;
            
            // Télécharger l'image uniquement si elle n'existe pas localement
            if (!Storage::disk('public')->exists($localPath)) {
                try {
                    $content = @file_get_contents($baseUrl . $imageName, false, $context);
                    if ($content) {
                        Storage::disk('public')->put($localPath, $content);
                    }
                } catch (\Throwable $e) {
                    // Échec silencieux du téléchargement ; l'enregistrement sera créé sans l'image physique
                }
            }

            // Synchronisation des données de la carte avec la base de données
            Card::updateOrCreate(
                ['name' => $data['name']],
                [
                    'elixir_cost' => $data['elixir'],
                    'rarity'      => $data['rarity'],
                    'arena'       => $data['arena'],
                    'image'       => $localPath,
                ]
            );
        }
    }
}