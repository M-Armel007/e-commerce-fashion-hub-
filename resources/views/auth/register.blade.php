<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Fashion Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Partie gauche avec image -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-purple-700 via-pink-600 to-orange-500 relative overflow-hidden items-center justify-center">
            <div class="relative z-10 text-white text-center p-12">
                <div class="w-32 h-32 bg-white rounded-3xl shadow-2xl flex items-center justify-center mx-auto mb-8 transform rotate-12 hover:rotate-0 transition duration-500">
                    <i class="fas fa-gem text-6xl text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600"></i>
                </div>
                <h2 class="text-4xl font-bold mb-4">Rejoignez l'aventure</h2>
                <p class="text-xl opacity-90 mb-8">Créez votre compte et profitez de tous nos avantages</p>
                <div class="space-y-4 max-w-sm mx-auto">
                    <div class="flex items-center space-x-3 bg-white bg-opacity-20 p-3 rounded-xl">
                        <i class="fas fa-gift text-2xl"></i>
                        <span>Offre de bienvenue -10%</span>
                    </div>
                    <div class="flex items-center space-x-3 bg-white bg-opacity-20 p-3 rounded-xl">
                        <i class="fas fa-clock text-2xl"></i>
                        <span>Accès aux ventes privées</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Partie droite avec formulaire -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="max-w-md w-full">
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Créer un compte</h2>
                    <p class="text-gray-600 mb-6">Rejoignez Fashion Hub en quelques clics</p>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Nom -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-600 focus:border-transparent transition @error('name') border-red-500 @enderror"
                                    placeholder="Jean Dupont">
                            </div>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Adresse email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-600 focus:border-transparent transition @error('email') border-red-500 @enderror"
                                    placeholder="jean@exemple.com">
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mot de passe -->
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input id="password" type="password" name="password" required
                                    class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-600 focus:border-transparent transition @error('password') border-red-500 @enderror"
                                    placeholder="••••••••">
                                <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i class="fas fa-eye text-gray-400 hover:text-pink-600 transition" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirmation mot de passe -->
                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input id="password_confirmation" type="password" name="password_confirmation" required
                                    class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-600 focus:border-transparent transition"
                                    placeholder="••••••••">
                                <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i class="fas fa-eye text-gray-400 hover:text-pink-600 transition" id="toggleConfirmPasswordIcon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Conditions d'utilisation -->
                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="terms" required class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-600">
                                    J'accepte les <a href="#" class="text-pink-600 hover:text-pink-700">conditions d'utilisation</a> et la <a href="#" class="text-pink-600 hover:text-pink-700">politique de confidentialité</a>
                                </span>
                            </label>
                        </div>

                        <!-- Bouton d'inscription -->
                        <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white font-semibold py-3 px-4 rounded-xl hover:from-purple-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-600 focus:ring-offset-2 transition transform hover:scale-105 duration-300">
                            <i class="fas fa-user-plus mr-2"></i>S'inscrire
                        </button>

                        <!-- Lien de connexion -->
                        <p class="text-center mt-6 text-gray-600">
                            Déjà inscrit ?
                            <a href="{{ route('login') }}" class="text-pink-600 hover:text-pink-700 font-semibold ml-1">
                                Connectez-vous
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const password = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId === 'password' ? 'togglePasswordIcon' : 'toggleConfirmPasswordIcon');
            
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