<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categorie;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['nom' => 'T-shirts Homme', 'type' => 'adulte', 'genre' => 'homme'],
            ['nom' => 'Chemises Homme', 'type' => 'adulte', 'genre' => 'homme'],
            ['nom' => 'Pantalons Homme', 'type' => 'adulte', 'genre' => 'homme'],
            ['nom' => 'Robes Femme', 'type' => 'adulte', 'genre' => 'femme'],
            ['nom' => 'Tops Femme', 'type' => 'adulte', 'genre' => 'femme'],
            ['nom' => 'Jeans Femme', 'type' => 'adulte', 'genre' => 'femme'],
            ['nom' => 'T-shirts Enfant', 'type' => 'enfant', 'genre' => 'mixte'],
            ['nom' => 'Pantalons Enfant', 'type' => 'enfant', 'genre' => 'mixte'],
        ];

        foreach ($categories as $categorie) {
            // Vérifier si la catégorie existe déjà
            $existingCategorie = Categorie::where('slug', Str::slug($categorie['nom']))->first();
            
            if (!$existingCategorie) {
                Categorie::create([
                    'nom' => $categorie['nom'],
                    'slug' => Str::slug($categorie['nom']),
                    'type' => $categorie['type'],
                    'genre' => $categorie['genre']
                ]);
            }
        }
    }
}