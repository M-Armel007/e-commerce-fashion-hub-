<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture #{{ $order->numero_commande }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print {
                display: none;
            }
            body {
                background: white;
            }
        }
    </style>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl p-8">
        <!-- Bouton d'impression (non imprimé) -->
        <div class="no-print text-right mb-4">
            <button onclick="window.print()" class="bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700">
                <i class="fas fa-print mr-2"></i>Imprimer
            </button>
        </div>

        <!-- En-tête de la facture -->
        <div class="border-b pb-6 mb-6">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-extrabold bg-gradient-to-r from-purple-600 to-pink-600 text-transparent bg-clip-text">FASHION HUB</h1>
                    <p class="text-gray-600 mt-1">123 Rue de la Mode</p>
                    <p class="text-gray-600">75001 Paris</p>
                    <p class="text-gray-600">contact@fashionhub.com</p>
                    <p class="text-gray-600">01 23 45 67 89</p>
                </div>
                <div class="text-right">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">FACTURE</h2>
                    <p class="text-gray-600">N° {{ $order->numero_commande }}</p>
                    <p class="text-gray-600">Date : {{ $order->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Informations client -->
        <div class="grid grid-cols-2 gap-8 mb-8">
            <div>
                <h3 class="font-semibold text-lg mb-2">Facturé à :</h3>
                @if($order->client)
                    <p class="font-medium">{{ $order->client->nom }} {{ $order->client->prenom }}</p>
                    <p class="text-gray-600">{{ $order->client->email }}</p>
                    @if($order->client->telephone)
                        <p class="text-gray-600">{{ $order->client->telephone }}</p>
                    @endif
                    @if($order->client->adresse)
                        <p class="text-gray-600">{{ $order->client->adresse }}</p>
                    @endif
                @else
                    <p class="text-gray-600">Client sur place</p>
                @endif
            </div>
            <div>
                <h3 class="font-semibold text-lg mb-2">Détails de la commande :</h3>
                <p class="text-gray-600">Type de vente : {{ $order->type_vente == 'en_ligne' ? 'En ligne' : 'Sur place' }}</p>
                <p class="text-gray-600">Statut : 
                    @if($order->statut == 'en_attente')
                        <span class="text-yellow-600">En attente</span>
                    @elseif($order->statut == 'confirmee')
                        <span class="text-blue-600">Confirmée</span>
                    @elseif($order->statut == 'livree')
                        <span class="text-green-600">Livrée</span>
                    @else
                        <span class="text-red-600">Annulée</span>
                    @endif
                </p>
            </div>
        </div>

        <!-- Tableau des articles -->
        <table class="w-full mb-8">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-3 text-left">Description</th>
                    <th class="px-4 py-3 text-center">Quantité</th>
                    <th class="px-4 py-3 text-right">Prix unitaire</th>
                    <th class="px-4 py-3 text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr class="border-b">
                    <td class="px-4 py-3">
                        <p class="font-medium">{{ $item->product->nom }}</p>
                        <p class="text-sm text-gray-600">{{ $item->product->categorie->nom }}</p>
                    </td>
                    <td class="px-4 py-3 text-center">{{ $item->quantite }}</td>
                    <td class="px-4 py-3 text-right">{{ number_format($item->prix_unitaire, 2) }} €</td>
                    <td class="px-4 py-3 text-right font-medium">{{ number_format($item->prix_unitaire * $item->quantite, 2) }} €</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Récapitulatif des totaux -->
        <div class="flex justify-end mb-8">
            <div class="w-64">
                <div class="flex justify-between py-2">
                    <span class="font-medium">Sous-total :</span>
                    <span>{{ number_format($order->total, 2) }} €</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="font-medium">TVA (20%) :</span>
                    <span>{{ number_format($order->total * 0.2, 2) }} €</span>
                </div>
                <div class="flex justify-between py-2 border-t border-b font-bold text-lg">
                    <span>Total TTC :</span>
                    <span class="text-pink-600">{{ number_format($order->total * 1.2, 2) }} €</span>
                </div>
            </div>
        </div>

        <!-- Pied de page -->
        <div class="border-t pt-6 text-center text-gray-600 text-sm">
            <p>Merci de votre confiance !</p>
            <p class="mt-2">Pour toute question concernant cette facture, contactez-nous à contact@fashionhub.com</p>
        </div>
    </div>

    <!-- Font Awesome pour les icônes (non imprimé) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</body>
</html>