<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Categorie;

class ProductsTableSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer les IDs des catégories existantes
        $categorieTshirtHomme = Categorie::where('slug', 't-shirts-homme')->first();
        $categorieJeansFemme = Categorie::where('slug', 'jeans-femme')->first();
        $categorieRobesFemme = Categorie::where('slug', 'robes-femme')->first();
        $categorieChemisesHomme = Categorie::where('slug', 'chemises-homme')->first();

        $products = [
            [
                'nom' => 'T-shirt Blanc Basic',
                'description' => 'T-shirt en coton blanc, coupe classique - Parfait pour tous les jours',
                'prix' => 19.99,
                'stock' => 50,
                'categorie_id' => $categorieTshirtHomme ? $categorieTshirtHomme->id : 1,
                'taille' => 'S,M,L,XL',
                'couleur' => 'Blanc'
            ],
            [
                'nom' => 'Jean Slim Noir',
                'description' => 'Jean slim noir stretch - Tendance et confortable',
                'prix' => 49.99,
                'stock' => 30,
                'categorie_id' => $categorieJeansFemme ? $categorieJeansFemme->id : 2,
                'taille' => '36,38,40,42',
                'couleur' => 'Noir'
            ],
            [
                'nom' => 'Robe d\'été Fleurie',
                'description' => 'Robe légère imprimé floral - Idéale pour l\'été',
                'prix' => 39.99,
                'stock' => 20,
                'categorie_id' => $categorieRobesFemme ? $categorieRobesFemme->id : 3,
                'taille' => 'S,M,L',
                'couleur' => 'Multicolore'
            ],
            [
                'nom' => 'Chemise Oxford Bleue',
                'description' => 'Chemise en coton bleu clair - Élégante et intemporelle',
                'prix' => 34.99,
                'stock' => 25,
                'categorie_id' => $categorieChemisesHomme ? $categorieChemisesHomme->id : 4,
                'taille' => 'S,M,L,XL',
                'couleur' => 'Bleu'
            ],
        ];

        foreach ($products as $product) {
            // Vérifier si le produit existe déjà
            $existingProduct = Product::where('nom', $product['nom'])->first();
            
            if (!$existingProduct) {
                Product::create($product);
            }
        }
    }
}