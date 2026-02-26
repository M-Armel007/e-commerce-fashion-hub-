<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Fashion Hub - Boutique en ligne')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .cart-count {
            @apply absolute -top-2 -right-2 bg-pink-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs;
        }
        .animate-pulse-slow {
            animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .7; }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Top Bar -->
    <div class="bg-gray-900 text-white text-sm py-2">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <span><i class="fas fa-truck mr-2"></i>Livraison gratuite dès 50€</span>
                <span class="hidden md:inline"><i class="fas fa-undo mr-2"></i>Retours gratuits 30 jours</span>
            </div>
            <div class="flex items-center space-x-4">
                <a href="#" class="hover:text-pink-400 transition"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="hover:text-pink-400 transition"><i class="fab fa-instagram"></i></a>
                <a href="#" class="hover:text-pink-400 transition"><i class="fab fa-twitter"></i></a>
            </div>
        </div>
    </div>

    <!-- Navigation principale -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-3xl font-extrabold">
                        <span class="bg-gradient-to-r from-purple-600 to-pink-600 text-transparent bg-clip-text">
                            FASHION HUB
                        </span>
                    </a>
                    
                    <!-- Menu desktop -->
                    <div class="hidden md:flex items-center space-x-6">
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-pink-600 transition font-medium {{ request()->routeIs('home') ? 'text-pink-600' : '' }}">
                            Accueil
                        </a>
                        <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-pink-600 transition font-medium {{ request()->routeIs('products.*') ? 'text-pink-600' : '' }}">
                            Boutique
                        </a>
                        
                        <!-- Mega menu -->
                        <div class="relative group">
                            <button class="text-gray-700 hover:text-pink-600 transition font-medium flex items-center">
                                Catégories
                                <i class="fas fa-chevron-down ml-1 text-xs"></i>
                            </button>
                            
                            <div class="absolute left-0 mt-2 w-64 bg-white rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                                <div class="py-2">
                                    <a href="{{ route('products.index', ['genre' => 'homme']) }}" class="block px-4 py-2 text-gray-700 hover:bg-pink-50 hover:text-pink-600">
                                        <i class="fas fa-mars mr-2"></i>Homme
                                    </a>
                                    <a href="{{ route('products.index', ['genre' => 'femme']) }}" class="block px-4 py-2 text-gray-700 hover:bg-pink-50 hover:text-pink-600">
                                        <i class="fas fa-venus mr-2"></i>Femme
                                    </a>
                                    <a href="{{ route('products.index', ['type' => 'enfant']) }}" class="block px-4 py-2 text-gray-700 hover:bg-pink-50 hover:text-pink-600">
                                        <i class="fas fa-child mr-2"></i>Enfant
                                    </a>
                                    <div class="border-t my-2"></div>
                                    <a href="{{ route('products.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-pink-50 hover:text-pink-600">
                                        <i class="fas fa-tag mr-2"></i>Promotions
                                    </a>
                                    <a href="{{ route('products.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-pink-50 hover:text-pink-600">
                                        <i class="fas fa-star mr-2"></i>Nouveautés
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Actions droite -->
                <div class="flex items-center space-x-4">
                    <!-- Recherche -->
                    <button class="text-gray-700 hover:text-pink-600 transition" onclick="toggleSearch()">
                        <i class="fas fa-search text-xl"></i>
                    </button>
                    
                    <!-- Compte -->
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-pink-600 transition">
                                <i class="fas fa-user-circle text-2xl"></i>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" 
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl py-2 z-50"
                                 x-cloak>
                                <div class="px-4 py-2 border-b">
                                    <p class="font-semibold">{{ Auth::user()->name }}</p>
                                    <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                                </div>
                                
                                @if(Auth::user()->is_admin ?? false)
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-pink-50 hover:text-pink-600">
                                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                    </a>
                                @endif
                                
                                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-pink-50 hover:text-pink-600">
                                    <i class="fas fa-user mr-2"></i>Mon profil
                                </a>
                                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-pink-50 hover:text-pink-600">
                                    <i class="fas fa-shopping-bag mr-2"></i>Mes commandes
                                </a>
                                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-pink-50 hover:text-pink-600">
                                    <i class="fas fa-heart mr-2"></i>Mes favoris
                                </a>
                                
                                <div class="border-t my-2"></div>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-pink-600 transition font-medium">
                            <i class="fas fa-sign-in-alt mr-1"></i>Connexion
                        </a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-4 py-2 rounded-lg hover:from-purple-700 hover:to-pink-700 transition font-medium">
                            Inscription
                        </a>
                    @endauth
                    
                    <!-- Panier -->
                    <a href="{{ route('cart.index') }}" class="relative">
                        <i class="fas fa-shopping-bag text-2xl text-gray-700 hover:text-pink-600 transition"></i>
                        @php $cartCount = count(session('cart', [])) @endphp
                        @if($cartCount > 0)
                            <span class="cart-count animate-pulse-slow">{{ $cartCount }}</span>
                        @endif
                    </a>
                    
                    <!-- Menu mobile -->
                    <button class="md:hidden text-gray-700 hover:text-pink-600 transition" onclick="toggleMobileMenu()">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Barre de recherche mobile -->
        <div id="searchBar" class="hidden bg-white border-t py-4">
            <div class="max-w-7xl mx-auto px-4">
                <form action="{{ route('products.index') }}" method="GET" class="flex gap-2">
                    <input type="text" name="search" placeholder="Rechercher un produit..." 
                           class="flex-1 border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-600"
                           value="{{ request('search') }}">
                    <button type="submit" class="bg-pink-600 text-white px-6 py-2 rounded-lg hover:bg-pink-700 transition">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Menu mobile -->
        <div id="mobileMenu" class="hidden md:hidden bg-white border-t py-4">
            <div class="max-w-7xl mx-auto px-4 space-y-2">
                <a href="{{ route('home') }}" class="block py-2 text-gray-700 hover:text-pink-600 transition">Accueil</a>
                <a href="{{ route('products.index') }}" class="block py-2 text-gray-700 hover:text-pink-600 transition">Boutique</a>
                <a href="{{ route('products.index', ['genre' => 'homme']) }}" class="block py-2 text-gray-700 hover:text-pink-600 transition">Homme</a>
                <a href="{{ route('products.index', ['genre' => 'femme']) }}" class="block py-2 text-gray-700 hover:text-pink-600 transition">Femme</a>
                <a href="{{ route('products.index', ['type' => 'enfant']) }}" class="block py-2 text-gray-700 hover:text-pink-600 transition">Enfant</a>
                <a href="{{ route('products.index') }}" class="block py-2 text-gray-700 hover:text-pink-600 transition">Promotions</a>
            </div>
        </div>
    </nav>

    <!-- Messages Flash -->
    <div class="max-w-7xl mx-auto px-4 mt-4">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center justify-between">
                <span><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg flex items-center justify-between">
                <span><i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif
    </div>

    <!-- Contenu principal -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-2xl font-extrabold mb-4">
                        <span class="bg-gradient-to-r from-purple-400 to-pink-400 text-transparent bg-clip-text">
                            FASHION HUB
                        </span>
                    </h3>
                    <p class="text-gray-400 mb-4">Votre destination mode préférée pour des vêtements tendance et de qualité.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-pink-400 transition text-xl">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-pink-400 transition text-xl">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-pink-400 transition text-xl">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-pink-400 transition text-xl">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="font-semibold text-lg mb-4">Liens utiles</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-pink-400 transition">À propos</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-pink-400 transition">Contact</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-pink-400 transition">Mentions légales</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-pink-400 transition">CGV</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-pink-400 transition">Politique de confidentialité</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold text-lg mb-4">Service client</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-pink-400 transition">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-pink-400 transition">Livraison</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-pink-400 transition">Retours</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-pink-400 transition">Suivi de commande</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-pink-400 transition">Guide des tailles</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold text-lg mb-4">Newsletter</h4>
                    <p class="text-gray-400 mb-4">Recevez nos offres exclusives</p>
                    <form class="flex">
                        <input type="email" placeholder="Votre email" 
                               class="flex-1 px-4 py-2 rounded-l-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-pink-600">
                        <button type="submit" class="bg-pink-600 text-white px-4 py-2 rounded-r-lg hover:bg-pink-700 transition">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                    <div class="mt-6">
                        <h4 class="font-semibold text-lg mb-2">Paiement sécurisé</h4>
                        <div class="flex space-x-2 text-2xl text-gray-400">
                            <i class="fab fa-cc-visa"></i>
                            <i class="fab fa-cc-mastercard"></i>
                            <i class="fab fa-cc-paypal"></i>
                            <i class="fab fa-cc-amex"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 Fashion Hub. Tous droits réservés. Créé avec <i class="fas fa-heart text-pink-600"></i> pour la mode</p>
            </div>
        </div>
    </footer>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        // Toggle search bar
        function toggleSearch() {
            const searchBar = document.getElementById('searchBar');
            searchBar.classList.toggle('hidden');
        }
        
        // Toggle mobile menu
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('hidden');
        }
        
        // Fermer les messages après 5 secondes
        setTimeout(() => {
            document.querySelectorAll('[class*="bg-green-100"], [class*="bg-red-100"]').forEach(el => {
                el.remove();
            });
        }, 5000);
    </script>
    
    @stack('scripts')
</body>
</html>