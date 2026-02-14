<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | Mon Application</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full">

<div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <div class="mx-auto h-12 w-12 bg-indigo-500 rounded-lg flex items-center justify-center shadow-lg shadow-indigo-500/50">
            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        
        <h2 class="mt-6 text-3xl font-extrabold text-white tracking-tight">
            Bon retour parmi nous
        </h2>
        <p class="mt-2 text-sm text-gray-400">
            Accédez à votre tableau de bord
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-gray-800 py-8 px-4 shadow-2xl sm:rounded-xl sm:px-10 border border-gray-700">
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300">
                        Adresse Email
                    </label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                            class="appearance-none block w-full px-4 py-3 border @error('email') border-red-500 @else border-gray-600 @enderror rounded-lg shadow-sm placeholder-gray-500 bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150 ease-in-out sm:text-sm"
                            placeholder="nom@exemple.com">
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium text-gray-300">
                            Mot de passe
                        </label>
                        <div class="text-sm">
                            <a href="#" class="font-medium text-indigo-400 hover:text-indigo-300 transition-colors">
                                Oublié ?
                            </a>
                        </div>
                    </div>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" required
                            class="appearance-none block w-full px-4 py-3 border @error('password') border-red-500 @else border-gray-600 @enderror rounded-lg shadow-sm placeholder-gray-500 bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150 ease-in-out sm:text-sm"
                            placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox" 
                        class="h-4 w-4 text-indigo-500 focus:ring-indigo-500 border-gray-600 rounded bg-gray-700 cursor-pointer">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-300 cursor-pointer">
                        Se souvenir de cet appareil
                    </label>
                </div>

                <div>
                    <button type="submit" 
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-indigo-500 transform active:scale-[0.98] transition-all duration-150">
                        SE CONNECTER
                    </button>
                </div>
            </form>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-700"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-gray-800 text-gray-400 italic">Nouveau ici ?</span>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="#" class="w-full flex justify-center py-2 px-4 border border-gray-600 rounded-lg text-sm font-medium text-gray-300 hover:bg-gray-700 transition-colors">
                        Créer un compte
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>