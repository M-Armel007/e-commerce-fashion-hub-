<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Fashion Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        .bg-pattern {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Partie gauche avec image et texte -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-purple-700 via-pink-600 to-orange-500 relative overflow-hidden">
            <!-- Cercles décoratifs -->
            <div class="absolute top-0 -left-20 w-64 h-64 bg-white opacity-10 rounded-full"></div>
            <div class="absolute bottom-0 -right-20 w-96 h-96 bg-white opacity-10 rounded-full"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-72 h-72 bg-white opacity-5 rounded-full"></div>
            
            <!-- Contenu -->
            <div class="relative z-10 flex flex-col items-center justify-center w-full h-full text-white p-12">
                <!-- Logo animé -->
                <div class="animate-float mb-8">
                    <div class="w-32 h-32 bg-white rounded-3xl shadow-2xl flex items-center justify-center transform rotate-12 hover:rotate-0 transition duration-500">
                        <i class="fas fa-tshirt text-6xl text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600"></i>
                    </div>
                </div>
                
                <h1 class="text-5xl font-extrabold mb-4 text-center">Fashion Hub</h1>
                <p class="text-xl text-center opacity-90 mb-8">Votre destination mode préférée</p>
                
                <!-- Caractéristiques -->
                <div class="space-y-4 w-full max-w-sm">
                    <div class="flex items-center space-x-3 bg-white bg-opacity-20 p-3 rounded-xl backdrop-blur-sm">
                        <i class="fas fa-check-circle text-2xl"></i>
                        <span>Plus de 1000 articles tendance</span>
                    </div>
                    <div class="flex items-center space-x-3 bg-white bg-opacity-20 p-3 rounded-xl backdrop-blur-sm">
                        <i class="fas fa-truck text-2xl"></i>
                        <span>Livraison gratuite dès 50€</span>
                    </div>
                    <div class="flex items-center space-x-3 bg-white bg-opacity-20 p-3 rounded-xl backdrop-blur-sm">
                        <i class="fas fa-undo text-2xl"></i>
                        <span>Retours gratuits 30 jours</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Partie droite avec formulaire -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="max-w-md w-full">
                <!-- Logo mobile -->
                <div class="lg:hidden text-center mb-8">
                    <div class="inline-block p-4 bg-gradient-to-br from-purple-600 to-pink-600 rounded-2xl shadow-lg mb-4">
                        <i class="fas fa-tshirt text-4xl text-white"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">Fashion Hub</h2>
                    <p class="text-gray-600">Connectez-vous à votre compte</p>
                </div>

                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Content de vous revoir !</h2>
                    <p class="text-gray-600 mb-6">Connectez-vous pour accéder à votre espace personnel</p>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-5">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Adresse email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-600 focus:border-transparent transition @error('email') border-red-500 @enderror"
                                    placeholder="votre@email.com">
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mot de passe -->
                        <div class="mb-5">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input id="password" type="password" name="password" required
                                    class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-600 focus:border-transparent transition @error('password') border-red-500 @enderror"
                                    placeholder="••••••••">
                                <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i class="fas fa-eye text-gray-400 hover:text-pink-600 transition" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Se souvenir de moi et Mot de passe oublié -->
                        <div class="flex items-center justify-between mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember" class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-600">Se souvenir de moi</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-pink-600 hover:text-pink-700 font-medium">
                                    Mot de passe oublié ?
                                </a>
                            @endif
                        </div>

                        <!-- Bouton de connexion -->
                        <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white font-semibold py-3 px-4 rounded-xl hover:from-purple-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-600 focus:ring-offset-2 transition transform hover:scale-105 duration-300">
                            <i class="fas fa-sign-in-alt mr-2"></i>Se connecter
                        </button>

                        <!-- Séparateur -->
                        <div class="relative my-6">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-white text-gray-500">Ou continuer avec</span>
                            </div>
                        </div>

                        <!-- Boutons sociaux -->
                        <div class="grid grid-cols-2 gap-3">
                            <button type="button" class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-xl hover:bg-gray-50 transition">
                                <i class="fab fa-google text-red-500 mr-2"></i>
                                <span class="text-sm font-medium text-gray-700">Google</span>
                            </button>
                            <button type="button" class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-xl hover:bg-gray-50 transition">
                                <i class="fab fa-facebook text-blue-600 mr-2"></i>
                                <span class="text-sm font-medium text-gray-700">Facebook</span>
                            </button>
                        </div>

                        <!-- Lien d'inscription -->
                        <p class="text-center mt-6 text-gray-600">
                            Pas encore de compte ?
                            <a href="{{ route('register') }}" class="text-pink-600 hover:text-pink-700 font-semibold ml-1">
                                Inscrivez-vous
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const icon = document.getElementById('togglePasswordIcon');
            
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>